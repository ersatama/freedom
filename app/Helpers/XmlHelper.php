<?php

namespace App\Helpers;

use Saloon\XmlWrangler\Exceptions\XmlReaderException;
use Saloon\XmlWrangler\XmlReader;
use Throwable;

trait XmlHelper
{
    /**
     * @throws Throwable
     * @throws XmlReaderException
     */
    public function parse($xmlRequest): XmlReader
    {
        $file = $xmlRequest->file('file');
        return XmlReader::fromFile($file);
    }

    /**
     * @throws Throwable
     */
    public function parseString($xml): XmlReader
    {
        return XmlReader::fromString($xml);
    }
}