# About project
Implementation of billing middleware software that handles SOAP requests from partners

## Testing
Make a post request to middleware.php with the SOAP data as shown in sample partner request below.

### ---- Request Coming into the middleware from partner
```xml
<?xml version="1.0" encoding="utf-8"?><soap11:Envelope xmlns:soap11="http://schemas.xmlsoap.org/soap/envelope/" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:tns="http://sdf.cellc.net/" 
xmlns:ns="http://sdf.cellc.net/commonDataModel" xmlns="http://sdf.cellc.net/">
<soap11:Body> <ns:SDF_Data><ns:header><ns:processTypeID>7100</ns:processTypeID><ns:externalReference>1609620022827</ns:externalReference>
<ns:sourceID>5555555</ns:sourceID><ns:username>AAA</ns:username><ns:password>AAAB</ns:password>
<ns:processFlag>1</ns:processFlag></ns:header><ns:parameters><ns:parameter name="I_TRANSACTION_ID">1609620022827</ns:parameter></ns:parameters>
</ns:SDF_Data></soap11:Body></soap11:Envelope>
```

### ---- Request from the middleware to the core application
```xml
<?xml version="1.0" encoding="utf-8"?><soap11:Envelope xmlns:soap11="http://schemas.xmlsoap.org/soap/envelope/" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:tns="http://sdf.cellc.net/" 
xmlns:ns="http://sdf.cellc.net/commonDataModel" xmlns="http://sdf.cellc.net/">
<soap11:Body><ns:SDF_Data><ns:header><ns:processTypeID>5000</ns:processTypeID><ns:externalReference>1609620022827</ns:externalReference>
<ns:sourceID>1111111</ns:sourceID><ns:username>BBB</ns:username><ns:password>BBBCD</ns:password><ns:processFlag>1</ns:processFlag></ns:header>
<ns:parameters><ns:parameter name="I_TRANSACTION_ID">1609620022827</ns:parameter></ns:parameters>
</ns:SDF_Data></soap11:Body></soap11:Envelope>
```

### ---- Response from the core application to the middle ware
```xml
<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
<SOAP-ENV:Body><ns0:SDF_Data xmlns:ns0="http://sdf.cellc.net/commonDataModel" processID=""><ns0:header><ns0:processTypeID>5000</ns0:processTypeID>
<ns0:externalReference>1609620022827</ns0:externalReference><ns0:sourceID>1111111</ns0:sourceID><ns0:username>BBB</ns0:username><ns0:password>BBBCD</ns0:password><ns0:processFlag>1</ns0:processFlag>
</ns0:header><ns0:result><ns0:statusCode>0</ns0:statusCode><ns0:errorCode>0</ns0:errorCode>
<ns0:errorDescription>Successful Transaction</ns0:errorDescription><ns0:resultElements>
<ns0:parameter name="O_RECHARGE_STATUS">SA</ns0:parameter><ns0:parameter name="O_RECHARGE_DESCRIPTION">The request was successful</ns0:parameter>
<ns0:parameter name="O_RESULT">0</ns0:parameter><ns0:parameter name="O_ERROR_CODE">SA</ns0:parameter>
<ns0:parameter name="O_ERROR_DESCRIPTION">The request was successful</ns0:parameter></ns0:resultElements></ns0:result>
</ns0:SDF_Data></SOAP-ENV:Body></SOAP-ENV:Envelope>
```

### --- Response from the middleware to the partner
```xml
<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
<SOAP-ENV:Body><ns0:SDF_Data xmlns:ns0="http://sdf.cellc.net/commonDataModel" processID=""><ns0:header><ns0:processTypeID>7100</ns0:processTypeID>
<ns0:externalReference>1609620022827</ns0:externalReference><ns0:sourceID>5555555</ns0:sourceID><ns0:username>AAA</ns0:username><ns0:password>AAAB</ns0:password><ns0:processFlag>1</ns0:processFlag>
</ns0:header><ns0:result><ns0:statusCode>0</ns0:statusCode><ns0:errorCode>0</ns0:errorCode><ns0:errorDescription>Successful Transaction</ns0:errorDescription>
<ns0:resultElements><ns0:parameter name="O_RECHARGE_STATUS">SA</ns0:parameter><ns0:parameter name="O_RECHARGE_DESCRIPTION">The request was successful</ns0:parameter>
<ns0:parameter name="O_RESULT">0</ns0:parameter><ns0:parameter name="O_ERROR_CODE">SA</ns0:parameter><ns0:parameter name="O_ERROR_DESCRIPTION">The request was successful</ns0:parameter>
</ns0:resultElements></ns0:result></ns0:SDF_Data></SOAP-ENV:Body></SOAP-ENV:Envelope>
```
