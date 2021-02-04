<?php
$date = date('d/m/Y H:i:s');
$response = <<<XML
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	<soap:Body>
		<ns2:requestTopupResponse xmlns:ns2="http://external.interfaces.ers.seamless.com/">
			<return>
				<ersReference>2016011416234742001000059</ersReference>
				<resultCode>0</resultCode>
				<resultDescription>SUCCESS</resultDescription>
				<requestedTopupAmount>
					<currency>NGN</currency>
					<value>50</value>
				</requestedTopupAmount>
				<senderPrincipal>
					<principalId>
						<id>DIST1</id>
						<type>RESELLERID</type>
					</principalId>
					<principalName>Distributor 1</principalName>
					<accounts>
						<account>
							<accountSpecifier>
								<accountId>DIST1</accountId>
								<accountTypeId>RESELLER</accountTypeId>
							</accountSpecifier>
							<balance>
								<currency>NGN</currency>
								<value>209750.00</value>
							</balance>
							<creditLimit>
								<currency>NGN</currency>
								<value>0.00000</value>
							</creditLimit>
						</account>
					</accounts>
					<status>Active</status>
					<msisdn>2342348010000</msisdn>
				</senderPrincipal>
				<topupAccountSpecifier>
					<accountId>2342348010101</accountId>
					<accountTypeId>AIRTIME</accountTypeId>
				</topupAccountSpecifier>
				<topupAmount>
					<currency>NGN</currency>
					<value>50.00</value>
				</topupAmount>
				<topupPrincipal>
					<principalId>
						<id>2342348010101</id>
						<type>SUBSCRIBERID</type>
					</principalId>
					<principalName />
					<accounts>
						<account>
							<accountSpecifier>
								<accountId>2342348010101</accountId>
								<accountTypeId>AIRTIME</accountTypeId>
							</accountSpecifier>
							<balance>
								<currency>NGN</currency>
								<value>100000.00</value>
							</balance>
						</account>
					</accounts>
				</topupPrincipal>
			</return>
		</ns2:requestTopupResponse>
	</soap:Body>
</soap:Envelope>
XML;
	
echo ($response);