<?php

namespace App\Http\Controllers\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLegalEntityRequest;
use App\Models\LegalEntity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Class LegalEntityController.
 */
class LegalEntityController extends Controller
{
    /**
     * @return View
     */
	public function index(): View
	{
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        $legalEntities = $customer->legalEntities()
            ->get()
            ->toArray();

		foreach ($legalEntities as &$legalEntity) {
            $legalEntity['id'] = Hashids::encode($legalEntity['id']);
        }

		return view('customer.account.legal_entities', compact('legalEntities'));
	}

    /**
     * @param StoreLegalEntityRequest $request
     * @return JsonResponse
     */
	public function store(StoreLegalEntityRequest $request): JsonResponse
	{
		// Retrieve the validated input data...
		$validatedData = $request->validated();

		$validatedData['customer_id'] = Auth::user()->customer->id;

		/* @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::create($validatedData);

		session()->flash('flash_success', __('alerts.customer.payment.need_validation', ['payer' => $legalEntity->alias]));

		return response()->json([
			'redirect' 	=> route('customer.legal_entities'),
			'status'	=> 'created'
		]);
	}

	public function update(StoreLegalEntityRequest $request, string $id): JsonResponse
    {
        $validatedData = $request->validated();
        /* @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::find(Hashids::decode($id)[0]);

        try {
            $legalEntity->update($validatedData);
            session()->flash('flash_success', 'Данные плательщика '. $legalEntity->alias .' успешно обновлены');

            return response()->json([
                'redirect'  => route('customer.legal_entities'),
                'status'    => 'updated'
            ]);
        } catch (MassAssignmentException $exception) {
            session()->flash('flash_error', 'Ошибка при обновлении данных плательщика '. $legalEntity->alias);

            return response()->json([
                'redirect'  => route('customer.legal_entities'),
                'status'    => 'error'
            ]);
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(string $id): JsonResponse
    {
        /* @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::find(Hashids::decode($id)[0]);

        $legalEntity->delete()
            ? session()->flash('flash_success', 'Плательщик '. $legalEntity->alias .' успешно удален')
            : session()->flash('flash_error', 'Ошибка при удалении плательщика '. $legalEntity->alias)
        ;

        return response()->json( ['redirect' => route('customer.legal_entities')] );
    }

    public function getList()
    {
        /* @var Customer $customer */
        $customer = Auth::user()->customer;

        return $customer->legalEntities()
            ->select(['id', 'alias', 'type'])
            ->get()
            ->toJson();
    }
}
