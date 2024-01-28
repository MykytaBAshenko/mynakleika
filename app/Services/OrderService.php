<?php

namespace App\Services;

use App\Helpers\General\LayoutHelper;
use App\Jobs\MoveLayoutsBundleToWorkFolder;
use App\Jobs\MoveSourcesBundleToWorkFolder;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\File;
use App\Models\Income;
use App\Models\Order;
use App\Models\Material;
use Carbon\Carbon;
use Cmixin\BusinessDay;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var PriceService
     */
    private $priceService;

    /**
     * OrderService constructor.
     * @param FileService $fileService
     * @param PriceService $priceService
     */
    public function __construct(FileService $fileService, PriceService $priceService)
    {
        $this->fileService = $fileService;
        $this->priceService = $priceService;
    }

    /**
     * @param array $data
     * @param Customer|null $customer
     * @return mixed
     */
    public function create(array $data, Customer $customer = null)
    {
        BusinessDay::enable('Carbon\Carbon', 'ua-national');
        Log::info($data);
        return DB::transaction(function () use ($data, $customer) {
            $file = $this->saveFile($data['file_name']);
            $order = $this->setOrder($data);
            $order->file()->associate($file);
            if ($customer === null) {
                $order->customer()->associate(Auth::user()->customer);
            } else {
                $order->customer()->associate($customer);
                if ($order->delivery->type !== Delivery::TYPE_PICKUP) {
                    $customer->deliveries()->attach($order->delivery);
                }
            }
            $order->save();
            $this->fileService->uploadCanvasPreview($file->name, $data['canvas_data']);
            $this->fileService->generateYmlLayoutsFile(
                $order->material->layoutW,
                $order->material->layoutH,
                $order->material->fieldH,
                $order->material->fieldW,
                $order->material->bleed,
                $order->id,
                $order->order_ref,
                $order->quantity,
                $order->end_at,
                $order->material,
                $data['width'],
                $data['height'],
                $data['rotate']
            );
            $this->fileService->copyFilesForGenerateLayouts($file->name, $order->id);
        });
    }

    /**
     * @param string $fileName
     * @return File
     */
    private function saveFile(string $fileName): File
    {
        $file = new File();
        $file->name = $fileName;
        $file->save();

        return $file;
    }

    /**
     * @param array $data
     * @return Order
     */
    private function setOrder(array $data): Order
    {
        $material = Material::find($data['material_id']);
        $order = new Order();
        $order->order_ref = $data['order_ref'];
        $order->order_comments = $data['order_comments'];
        $order->delivery_id = $data['delivery_id'];
        $order->material_id = $data['material_id'];
        $order->quantity = $data['quantity'];
        $order->format = $data['width']. 'x' .$data['height'];
        $order->chromaticity = $data['chromaticity'];
        $order->lamination = $data['lamination'];
        $order->production_status = Order::HOLD;
        $order->finance_status = Order::NOT_PAID;
        $order->delivery_cost = 0;
        $order->created_at = Carbon::now();
        $order->end_at = Carbon::now()->addBusinessDays($data['days'])->subBusinessDay();
        $order->cost = $this->priceService->calculatePrice(
            (int)$data['quantity'],
            (int)$data['width'],
            (int)$data['height'],
            (int)$data['rotate'],
            (int)$data['days'],
            (int)$data['material_id'],
            (int)$data['lamination']
        );
        $order->quantity_per_sheet = LayoutHelper::quantityPerSheet($data['width'], $data['height'], $material);


        return $order;
    }

    /**
     * @param Income $income
     */
    public function updateOrdersStatusOnIncome(Income $income): void
    {
        $invoice = $income->invoice;
        $orders = $invoice->orders()->unpaidAndPartlyPaid()->orderBy('end_at', 'asc')->get();

        /* Get sum of all invoice incomes, with previously incomes if their exists */
        $payedSum = $invoice->getPayedSum() + $income->value;

        foreach ($orders as $order) {
            /* @var Order $order */

            if ($payedSum >= $order->cost) {
                $order->finance_status = Order::PAID;
                $order->production_status = Order::IN_PROGRESS;
            } elseif ($payedSum < $order->cost && $payedSum > 0) {
                $order->finance_status = Order::PARTLY_PAID;
            } else {
                continue;
            }

            $payedSum -= $order->cost;
            $order->save();
        }
    }

    /**
     * @param array $orders
     */
    public function scheduleOrdersFileTransfer(Collection $orders): void
    {
        foreach ($orders as $order) {
            /* @var Order $order */
            if ($order->finance_status === Order::PAID) {
                MoveSourcesBundleToWorkFolder::dispatch($order->id);
                MoveLayoutsBundleToWorkFolder::dispatch($order->id);
            }
        }
    }
}
