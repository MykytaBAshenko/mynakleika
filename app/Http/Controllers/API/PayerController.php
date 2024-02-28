<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PayerUpdateRequest;
use App\Models\LegalEntity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class PayerController
 * @package App\Http\Controllers\API
 */
class PayerController extends Controller
{
    public function list(Request $request): LengthAwarePaginator
    {
        $verificationStatus = $request->get('verification_status');

        $query = DB::table(LegalEntity::getTableName())
            ->orderBy('created_at', 'desc');

        if ($verificationStatus) {
            $query = $query->where('verification_status', $verificationStatus);
        }

        return $query->paginate();
    }

    public function update(PayerUpdateRequest $request, int $legalEntityId)
    {
        $legalEntity = LegalEntity::find($legalEntityId);
        try {
            if ($request->verification_status == 3) {
                $sql = "DELETE FROM legal_entities WHERE id = ?";
                DB::delete($sql, [$legalEntityId]); 
            } else {
                $legalEntity->update($request->validated());
            }
            return response()->json( ['status' => 'success'] );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json( ['status' => 'error'] );
        }
    }
}
