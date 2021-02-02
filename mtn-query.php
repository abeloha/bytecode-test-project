<?php

$response = <<<XML
	<?xml version="1.0" encoding="UTF-8" standalone="no"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	 <soapenv:Header/>
	 <soapenv:Body>
	 <queryTxResponse>
	 <message>SUCCESSFUL</message>
	 <statusId>0</statusId>
	 </queryTxResponse>
	 </soapenv:Body>
	</soapenv:Envelope>
	XML;
	
echo $response;
?>