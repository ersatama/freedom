<?php

namespace App\Jobs;

use App\Services\Currency\CurrencyCommandService;
use App\Services\Currency\CurrencyQueryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCurrency implements ShouldQueue
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
        CurrencyCommandService $currencyCommandService,
        CurrencyQueryService $currencyQueryService
    ): void
    {
        $currency = $currencyQueryService->first($this->data);
        if ($currency) {
            $currencyCommandService->updateData($currency, $this->data);
        } else {
            $currencyCommandService->create($this->data);
        }
    }
}
