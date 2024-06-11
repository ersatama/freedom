<?php

namespace App\Jobs;

use App\Services\Exchange\ExchangeCommandService;
use App\Services\Exchange\ExchangeQueryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateExchange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected array $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(
        ExchangeCommandService $exchangeCommandService,
        ExchangeQueryService $exchangeQueryService,
    ): void
    {
        $exchange = $exchangeQueryService->first($this->data);
        if (!$exchange) {
            $exchangeCommandService->create($this->data);
        }
    }
}
