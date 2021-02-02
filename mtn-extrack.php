<?php

//Testing

$response = <<<XML
	<?xml version="1.0" encoding="UTF-8" standalone="no"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	 <soapenv:Header/>
	 <vendResponse>
	 <destBalance>998860.0</destBalance>
	 <destMsisdn>09062058617</destMsisdn>
	 <origBalance>999360.0</origBalance>
	 <origMsisdn>2349062058470</origMsisdn>
	 <responseCode>0</responseCode>
	 <responseMessage>Successful</responseMessage>
	 <sequence>139</sequence>
	 <statusId>0</statusId>
	 <txRefId>2018122611455497901000006</txRefId>
	 <voucherPIN>40692125281574</voucherPIN>
	 <voucherSerial>600000000001</voucherSerial>
	 </vendResponse>
	 </soapenv:Body>
	</soapenv:Envelope>
	XML;
	
libxml_use_internal_errors(true);
$sxe = simplexml_load_string($xml);

//return false if not a valid XML
if (false === $sxe) {
	echo 'invalid data';
	return false;
}
echo json_encode(XmlToArray::convert($response));




/**
 * @author Adrien aka Gaarf & contributors
 * @author Mark Townsend
 */
class XmlToArray
{
    /**
     * Convert valid XML to an array.
     *
     * @param string $xml
     * @param bool $outputRoot
     * @return array
     */
    public static function convert($xml, $outputRoot = false)
    {
        $array = self::xmlStringToArray($xml);
        if (!$outputRoot && array_key_exists('@root', $array)) {
            unset($array['@root']);
        }
        return $array;
    }

    protected static function xmlStringToArray($xmlstr)
    {
        $doc = new DOMDocument();
        $doc->loadXML($xmlstr);
        $root = $doc->documentElement;
        $output = self::domNodeToArray($root);
        $output['@root'] = $root->tagName;
        return $output;
    }

    protected static function domNodeToArray($node)
    {
        $output = [];
        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = self::domNodeToArray($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;
                        if (!isset($output[$t])) {
                            $output[$t] = [];
                        }
                        $output[$t][] = $v;
                    } elseif ($v || $v === '0') {
                        $output = (string) $v;
                    }
                }
                if ($node->attributes->length && !is_array($output)) { // Has attributes but isn't an array
                    $output = ['@content' => $output]; // Change output into an array.
                }
                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = [];
                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }
                        $output['@attributes'] = $a;
                    }
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1 && $t != '@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }
}
