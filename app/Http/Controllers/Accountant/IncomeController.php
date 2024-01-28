<?php

namespace App\Http\Controllers\Accountant;

use App\Models\Income;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Controllers\Controller;
use App\Events\Income\IncomeCreated;
use App\Services\IncomeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class IncomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
	public function index()
    {
        return view('accountant.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIncomeRequest $request
     * @param IncomeService $incomeService
     * @return JsonResponse
     */
	public function store(
	    StoreIncomeRequest $request,
        IncomeService $incomeService
    ): JsonResponse
	{
        $income = $incomeService->saveIncome($request->all());

	    if ($income instanceof Income) {
            event(new IncomeCreated($income));

            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }
}
