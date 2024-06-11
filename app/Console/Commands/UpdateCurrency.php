<?php

namespace App\Console\Commands;

use App\Helpers\CurlHelper;
use App\Helpers\XmlHelper;
use App\Jobs\SaveCurrency;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Throwable;

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
     *
     * @throws ConnectionException
     * @throws Throwable
     */
    public function handle() {
        $curl = $this->get($this->url);
        if ($curl->successful()) {
            $xmlReader = $this->parseString($curl->body());
            $values = $xmlReader->values();
            if (
                array_key_exists('Valuta', $values)
                && array_key_exists('Item', $values['Valuta'])
            ) {
                foreach ($values['Valuta']['Item'] as $key => $value) {
                    $attr = $xmlReader->element('Item.' . $key)->sole()
                        ->getAttributes();
                    SaveCurrency::dispatch([
                        'currency_id' => trim($attr['ID']),
                        'name'        => trim($value['Name']),
                        'eng_name'    => trim($value['EngName']),
                        'nominal'     => $value['Nominal'],
                        'parent_code' => trim($value['ParentCode']),
                    ]);
                }
            }
        } else {
            Log::error($curl->body());
        }
    }
}
