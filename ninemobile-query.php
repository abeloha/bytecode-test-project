<?php

$response = <<<XML
	<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
		<SOAP-ENV:Body>
			<ns0:SDF_Data xmlns:ns0="http://sdf.et.net/commonDataModel" processID="">
				<ns0:header>
					<ns0:processTypeID></ns0:processTypeID>
					<ns0:externalReference></ns0:externalReference>
					<ns0:sourceID></ns0:sourceID>
					<ns0:username></ns0:username>
					<ns0:password></ns0:password>
					<ns0:processFlag></ns0:processFlag>
				</ns0:header>
				<ns0:result>
					<ns0:statusCode>0</ns0:statusCode>
					<ns0:errorCode>0</ns0:errorCode>
					<ns0:errorDescription>Successful Transaction</ns0:errorDescription>
					<ns0:resultElements>
						<ns0:parameter name="O_RECHARGE_STATUS">SA</ns0:parameter>
						<ns0:parameter name="O_RECHARGE_DESCRIPTION">The request was successful</ns0:parameter>
						<ns0:parameter name="O_RESULT">SA</ns0:parameter>
						<ns0:parameter name="O_ERROR_CODE">SA</ns0:parameter>
						<ns0:parameter name="O_ERROR_DESCRIPTION">The request was successful</ns0:parameter>
					</ns0:resultElements>
				</ns0:result>
			</ns0:SDF_Data>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
	XML;
	
echo $response;

?>