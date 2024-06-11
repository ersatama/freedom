<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\{
    CurrencyCollection,
    CurrencyResource
};
use App\Services\Currency\{
    CurrencyQueryService
};
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CurrencyController extends Controller
{
    public function __construct(
        private readonly CurrencyQueryService $currencyQueryService,
        private readonly PaginationHelper $paginationHelper
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/currency/get",
     *     operationId="currenct.get",
     *     summary="Получить список валют",
     *     tags={"Currency"},
     *     @OA\Parameter(
     *       name="trashed",
     *       description="with deleted records (with, only)",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           example="with"
     *       ),
     *     ),
     *     @OA\Parameter(
     *       name="page",
     *       description="pagination",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *           type="integer",
     *           example=1
     *       )
     *     ),
     *     @OA\Parameter(
     *        name="take",
     *        description="limit",
     *        in="query",
     *        required=false,
     *        @OA\Schema(
     *            type="integer",
     *            example=20
     *        )
     *      ),
     *     @OA\Response(
     *       response=200,
     *       description="ok",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              example={
     *                  "data": "..."
     *              }
     *          )
     *       )
     *     ),
     * )
     */
    public function get(): JsonResponse
    {
        return response()->json(
            array_merge(
                $this->paginationHelper->count($this->currencyQueryService->count()),
                [
                    'data' => new CurrencyCollection($this->currencyQueryService->get())
                ]
            ), ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/currency/id/{id}",
     *     operationId="currency.firstById",
     *     summary="Получить валюту по ID",
     *     tags={"Currency"},
     *     @OA\Parameter(
     *       name="id",
     *       description="id",
     *       in="path",
     *       required=true,
     *       @OA\Schema(
     *           type="integer",
     *           example=1
     *       )
     *     ),
     *     @OA\Response(
     *       response=200,
     *       description="ok",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              example={
     *                  "data": {
    "id": 1,
    "currency_id": "R01010",
    "name": "Австралийский доллар",
    "eng_name": "Australian Dollar",
    "nominal": "1",
    "parent_code": "R01010    ",
    "created_at": "2024-06-10T20:36:39.000000Z",
    "updated_at": "2024-06-10T20:36:39.000000Z",
    }
     *              }
     *          )
     *       )
     *     ),
     *     @OA\Response(
     *       response=404,
     *       description="not found",
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              example={
    "message": "Not found",
    }
     *          )
     *       )
     *     )
     * )
     */
    public function id($id): JsonResponse
    {
        $currency = $this->currencyQueryService->first([
            'id' => $id
        ]);
        if (!$currency) {
            return response()->json([
                'status'  => 'error',
                'message' => 'not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }
        return response()->json([
            'data' => new CurrencyResource($currency)
        ], ResponseAlias::HTTP_OK);
    }
}
