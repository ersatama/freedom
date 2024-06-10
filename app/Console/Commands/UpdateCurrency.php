<?php

namespace App\Console\Commands;

use App\Helpers\CurlHelper;
use App\Helpers\XmlHelper;
use App\Services\Currency\CurrencyCommandService;
use App\Services\Currency\CurrencyQueryService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class UpdateCurrency extends Command
{
    use XmlHelper;
    use CurlHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency from crb.ru';

    protected string $url = 'https://cbr.ru/scripts/XML_val.asp';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(
        CurrencyQueryService $currencyQueryService,
        CurrencyCommandService $currencyCommandService,
    )
    {
        $curl = $this->get($this->url);
        Log::info('curl', [$curl]);
    }
}
