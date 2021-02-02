<?php

$response = <<<XML
	<?xml version='1.0' encoding='UTF-8'?><soapenv:Envelope
	xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	<soapenv:Header/><soapenv:Body><vendResponse>
	 <destBalance>0.0</destBalance>
	 <destMsisdn>09062058617</destMsisdn>
	 <origBalance>0.0</origBalance>
	 <origMsisdn>2349062058470</origMsisdn>
	 <responseCode>1</responseCode>
	 <responseMessage>This specific product is not available</responseMessage>
	 <sequence>140</sequence>
	 <statusId>540</statusId>
	 <txRefId>2018122711391346701000012</txRefId>
	</vendResponse></soapenv:Body> </soapenv:Envelope>
	XML;
	
echo $response;
?>