<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Exchange\{
    ExchangeCollection,
    ExchangeResource
};
use App\Services\Exchange\ExchangeQueryService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ExchangeController extends Controller
{
    public function __construct(
        private readonly ExchangeQueryService $exchangeQueryService,
        private readonly PaginationHelper $paginationHelper
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/exchange/get",
     *     operationId="exchange.get",
     *     summary="Получить список курса валют",
     *     tags={"Exchange"},
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
                $this->paginationHelper->count($this->exchangeQueryService->count()),
                [
                    'data' => new ExchangeCollection($this->exchangeQueryService->get())
                ]
            ), ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/exchange/id/{id}",
     *     operationId="exchange.firstById",
     *     summary="Получить курс валюты по ID",
     *     tags={"Exchange"},
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
    "valute_id": "R01010",
    "num_code": "036",
    "char_code": "AUD",
    "nominal": 1,
    "name": "Австралийский доллар",
    "value": "59,2211",
    "vunit_rate": "59,2211",
    "date": "2024-06-10",
    "created_at": "2024-06-10T22:22:55.000000Z",
    "updated_at": "2024-06-10T22:22:55.000000Z"
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
        $exchange = $this->exchangeQueryService->first([
            'id' => $id
        ]);
        if (!$exchange) {
            return response()->json([
                'status'  => 'error',
                'message' => 'not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }
        return response()->json([
            'data' => new ExchangeResource($exchange)
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/exchange/id/{id}/{day}",
     *     operationId="exchange.day",
     *     summary="Получить курс валюты по ID и сравнит с курсом {day}-дней назад",
     *     tags={"Exchange"},
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
     *     @OA\Parameter(
     *       name="day",
     *       description="day",
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
    "valute_id": "R01010",
    "num_code": "036",
    "char_code": "AUD",
    "nominal": 1,
    "name": "Австралийский доллар",
    "value": "59,2211",
    "vunit_rate": "59,2211",
    "date": "2024-06-10",
    "created_at": "2024-06-10T22:22:55.000000Z",
    "updated_at": "2024-06-10T22:22:55.000000Z"
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
    public function compare($id, $day): JsonResponse
    {
        $exchange = $this->exchangeQueryService->first([
            'id' => $id
        ]);
        if (!$exchange) {
            return response()->json([
                'status'  => 'error',
                'message' => 'not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }
        $previousDate = date_create($exchange->date);
        date_sub(
            $previousDate,
            date_interval_create_from_date_string($day . ' day')
        );
        $previousExchange = $this->exchangeQueryService->first([
            'valute_id' => $exchange->valute_id,
            'num_code'  => $exchange->num_code,
            'char_code' => $exchange->char_code,
            'nominal'   => $exchange->nominal,
            'date'      => date_format($previousDate, 'Y-m-d')
        ]);
        if ($previousExchange) {
            $exchange->value_old = $previousExchange->value;
            $exchange->vunit_rate_old = $previousExchange->vunit_rate;
            $exchange->value_diff = $exchange->value - $previousExchange->value;
            $exchange->vunit_rate_diff = $exchange->vunit_rate
                - $previousExchange->vunit_rate;
        }
        return response()->json([
            'data' => new ExchangeResource($exchange)
        ], ResponseAlias::HTTP_OK);
    }
}
