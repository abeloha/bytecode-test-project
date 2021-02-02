<?php

$response = <<<XML
	<?xml version='1.0' encoding='UTF-8'?><soapenv:Envelope
	xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	 <soapenv:Header/><soapenv:Body><vendResponse>
	 <destBalance>0.0</destBalance>
	 <origBalance>0.0</origBalance>
	  <responseCode>310</responseCode>
	 <responseMessage>INVALID TARRIF ID</responseMessage>
	 <sequence>0</sequence>
	 <statusId>540</statusId>
	 <txRefId>2018122711391346701000012</txRefId>
	</vendResponse></soapenv:Body> </soapenv:Envelope>
	XML;
	
echo $response;

?>