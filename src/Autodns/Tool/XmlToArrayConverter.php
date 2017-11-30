<?php

namespace Autodns\Tool;


use Autodns\Tool\Exception\InvalidXml;

class XmlToArrayConverter
{
    /**
     * @param string $xmlString
     * @return array
     */
    public function convert($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        if ($xml === false) {
            throw new InvalidXml("XmlToArrayConverter: Invalid XML given:\n{$xml}");
        }
        $json = json_encode($xml);
        return json_decode($json, true);
    }
}