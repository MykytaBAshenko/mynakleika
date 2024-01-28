<?php

namespace App\Console\Commands;

use App\Helpers\General\LayoutHelper;
use App\Helpers\General\MoneyHelper;
use App\Jobs\Worker;
use App\Models\PayGateOrder;
use App\Services\FileService;
use App\Services\PriceService;
use App\Services\XmlProcessService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;

class TestCommand extends Command
{
    use InteractsWithAuthentication;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param FileService $fileService
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(FileService $fileService)
    {
//        $payGateOrder = new PayGateOrder();
//        $payGateOrder->paygate_id = PayGateOrder::PAYGATE_PROVIDER_PORTMONE;
//        $payGateOrder->save();
//        $payGateOrder->orders()->attach(['100001', '100002']);
//        $priceService = new PriceService();

//        $payGateOrder = PayGateOrder::find(2);
        //dd((30 + option('bleed') * 2));
//        dd((float) option('layoutW') - (float) option('fieldW') * 2 + (float) option('bleed') * 2);
//        dd(LayoutHelper::fitAcross(30));
//        dd(LayoutHelper::quantityPerSheet(30, 50));
//        dd($priceService->priceOfOneBySheets(101, 1));
//        dd($priceService->calculatePrice(1000, 30, 50, 0, 4, 1, 1));
//        dd(sprintf(PayGateOrder::PAYGATE_PROVIDER_PREFIXES[$payGateOrder->paygate_id].'%09d', $payGateOrder->id));
    }
}


