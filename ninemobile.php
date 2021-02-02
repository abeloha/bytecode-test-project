<?php
$response = <<<XML
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		<soapenv:Header/>
		<soapenv:Body>
			<SDF_Data processID="" xmlns:ns0="http://sdf.et.net/commonDataModel" xmlns="http://sdf.et.net/commonDataModel">
				<com:header>
					<com:processTypeID>7002</com:processTypeID>
					<com:externalReference>20100412:12501213608093</com:externalReference>
					<com:sourceID>10700006</com:sourceID>
					<com:username>Abel</com:username>
					<com:password>Abel</com:password>
					<com:processFlag>1</com:processFlag>
				</com:header>
				<com:parameters name="">
					<com:parameter name="RechargeType">001</com:parameter>
					<com:parameter name="MSISDN">0847094750</com:parameter>
					<com:parameter name="Amount">500</com:parameter>
					<com:parameter name="Channel_ID">00006SHPHCPTN</com:parameter>
				</com:parameters>
				<ns0:result>				
					<ns0:statusCode>0</ns0:statusCode>
					<ns0:errorCode>0</ns0:errorCode>
					<ns0:errorDescription>Transaction Successful. Reference number: 44485547</ns0:errorDescription>
					<ns0:instanceId>44485547</ns0:instanceId>
				</ns0:result>
			</SDF_Data>
		</soapenv:Body>
		</soapenv:Envelope>
	XML;
echo $response;
?>