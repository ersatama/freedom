<?php

namespace App\Console\Commands;

use App\Helpers\CurlHelper;
use App\Helpers\XmlHelper;
use App\Jobs\UpdateExchange;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateExchangeRate extends Command
{
    use XmlHelper;
    use CurlHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-exchange-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected string $url = 'https://www.cbr.ru/scripts/XML_daily.asp?date_req=';

    /**
     * Execute the console command.
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function handle()
    {
        $dateValue = date('Y-m-d');
        $date = date('d/m/Y', strtotime($dateValue));
        $curl = $this->get($this->url . $date);
        if ($curl->successful()) {
            $xmlReader = $this->parseString($curl->body());
            $values = $xmlReader->values();
            if (
                array_key_exists('ValCurs', $values)
                && array_key_exists('Valute', $values['ValCurs'])
            ) {
                foreach ($values['ValCurs']['Valute'] as $key => $value) {
                    $attr = $xmlReader->element('Valute.' . $key)->sole()
                        ->getAttributes();
                    UpdateExchange::dispatch([
                        'valute_id'  => trim($attr['ID']),
                        'num_code'   => trim($value['NumCode']),
                        'char_code'  => trim($value['CharCode']),
                        'nominal'    => trim($value['Nominal']),
                        'name'       => trim($value['Name']),
                        'value'      => str_replace(',', '.', $value['Value']),
                        'vunit_rate' => str_replace(',', '.', $value['VunitRate']),
                        'date'       => $dateValue,
                    ]);
                }
            }
        } else {
            Log::error($curl->body());
        }
    }
}
