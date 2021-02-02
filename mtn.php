<?php

$response = <<<XML
	<?xml version="1.0" encoding="UTF-8" standalone="no"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	 <soapenv:Header/>
	 <soapenv:Body>
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
	
echo $response;

?>