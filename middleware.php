<?php

$xml_request = NULL;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xml_request = trim(file_get_contents('php://input'));
}else{
    echo 'Method not allowed.'; die;
}

if(empty($xml_request)){ //test that post data is sent
    echo 'Invalid request.'; die;
}

header('Content-type: text/xml; charset=utf-8');
$middlewareApp = new MiddlewareApp($xml_request);
$xml_response  = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
        <SOAP-ENV:Body>
            <ns0:SDF_Data xmlns:ns0="http://sdf.cellc.net/commonDataModel" processID="">
                <ns0:header>
                    <ns0:processTypeID>$middlewareApp->processTypeID</ns0:processTypeID>
                    <ns0:externalReference>$middlewareApp->externalReference</ns0:externalReference>
                    <ns0:sourceID>$middlewareApp->sourceID</ns0:sourceID>
                    <ns0:username>$middlewareApp->username</ns0:username>
                    <ns0:password>$middlewareApp->password</ns0:password>
                    <ns0:processFlag>$middlewareApp->processFlag</ns0:processFlag>
                </ns0:header>
                <ns0:result>
                    <ns0:statusCode>$middlewareApp->statusCode</ns0:statusCode>
                    <ns0:errorCode>$middlewareApp->errorCode</ns0:errorCode>
                    <ns0:errorDescription>$middlewareApp->errorDescription</ns0:errorDescription>
                    <ns0:resultElements>
                        <ns0:parameter name="O_RECHARGE_STATUS">$middlewareApp->O_RECHARGE_STATUS</ns0:parameter>
                        <ns0:parameter name="O_RECHARGE_DESCRIPTION">$middlewareApp->O_RECHARGE_DESCRIPTION</ns0:parameter>
                        <ns0:parameter name="O_RESULT">$middlewareApp->O_RESULT</ns0:parameter>
                        <ns0:parameter name="O_ERROR_CODE">$middlewareApp->O_ERROR_CODE</ns0:parameter>
                        <ns0:parameter name="O_ERROR_DESCRIPTION">$middlewareApp->O_ERROR_DESCRIPTION</ns0:parameter>
                    </ns0:resultElements>
                </ns0:result>
            </ns0:SDF_Data>
        </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
    XML;

echo $xml_response;

class MiddlewareApp 
{
    public ?int $statusCode = NULL;
    public ?int $errorCode = NULL;

    public ?string $processTypeID = NULL;
    public ?string $externalReference = NULL;
    public ?string $sourceID = NULL;
    public ?string $username = NULL;
    public ?string $password = NULL;
    public ?string $processFlag = NULL;
    public ?string $errorDescription = NULL;

    public ?string $O_RECHARGE_STATUS = NULL;
    public ?string $O_RECHARGE_DESCRIPTION = NULL;
    public ?string $O_RESULT = NULL;
    public ?string $O_ERROR_CODE = NULL;
    public ?string $O_ERROR_DESCRIPTION = NULL;

    public function __construct($xml_request){        
        //extract data from the xml request.
        $input_data = $this->extrateXMLData($xml_request);        
        if($input_data){
            $this->main($input_data);
        }else{
            $this->errorDescription = 'invalid Request (not a valid XML)';
        }
        
    }

    private function main($input_data){
        $this->processTypeID = $input_data['processTypeID'];
        $this->externalReference = $input_data['externalReference'];
        $this->sourceID = $input_data['sourceID'];
        $this->username = $input_data['username'];
        $this->password = $input_data['password'];
        $this->processFlag = $input_data['processFlag'];

        $this->statusCode = $this->statusCode;
        $this->errorCode = $this->errorCode;

        if($this->authenticate($input_data['username'],$input_data['password'])){
            $this->statusCode = 0;
            $this->errorCode = 0;
            $this->queryCore($input_data);
        }else{
            $this->errorDescription = 'invalid username ('.$this->username.') and password';
        }

    }

    private function extrateXMLData($xml_request, $from_core = false)
    //return array of extracted parameters
    {
        
        libxml_use_internal_errors(true);
        $sxe = simplexml_load_string($xml_request);

        if (false === $sxe) {
            return false;
        }

        //create model for extracted data
        $data = array(
            'processTypeID'=>'',
            'externalReference'=>'',
            'sourceID'=>'',
            'username'=>'',
            'password'=>'',
            'processFlag'=>'',
            'I_TRANSACTION_ID'=>'',
        );

        $sxe->registerXPathNamespace('c', 'http://sdf.cellc.net/commonDataModel');

        //test for each node to avoid offset on null

        if($sxe->xpath('//c:processTypeID'))
            $data['processTypeID'] = $sxe->xpath('//c:processTypeID')[0];        
        if($sxe->xpath('//c:externalReference'))
            $data['externalReference'] = $sxe->xpath('//c:externalReference')[0];
        if($sxe->xpath('//c:sourceID'))
            $data['sourceID'] = $sxe->xpath('//c:sourceID')[0];
        if($sxe->xpath('//c:username'))
            $data['username'] = $sxe->xpath('//c:username')[0];
        if($sxe->xpath('//c:password'))
            $data['password'] = $sxe->xpath('//c:password')[0];
        if($sxe->xpath('//c:processFlag'))
            $data['processFlag'] = $sxe->xpath('//c:processFlag')[0];        
        if($sxe->xpath('//c:parameter[@name="I_TRANSACTION_ID"]'))
            $data['I_TRANSACTION_ID'] = $sxe->xpath('//c:parameter[@name="I_TRANSACTION_ID"]')[0];
        
        
        
        return $data;
    }

    private function extrateCoreXMLData($xml_core_response)
    //return array of extracted parameters
    {
        libxml_use_internal_errors(true);
        $sxe = simplexml_load_string($xml_core_response);
        if (false === $sxe) {
            return false;
        }

        $sxe->registerXPathNamespace('c', 'http://sdf.cellc.net/commonDataModel');

        if($sxe->xpath('//c:parameter[@name="O_RECHARGE_STATUS"]'))
            $this->O_RECHARGE_STATUS = $sxe->xpath('//c:parameter[@name="O_RECHARGE_STATUS"]')[0];
        if($sxe->xpath('//c:parameter[@name="O_RECHARGE_DESCRIPTION"]'))
            $this->O_RECHARGE_DESCRIPTION = $sxe->xpath('//c:parameter[@name="O_RECHARGE_DESCRIPTION"]')[0];
        if($sxe->xpath('//c:parameter[@name="O_RESULT"]'))
            $this->O_RESULT = $sxe->xpath('//c:parameter[@name="O_RESULT"]')[0];
        if($sxe->xpath('//c:parameter[@name="O_ERROR_CODE"]'))
            $this->O_ERROR_CODE = $sxe->xpath('//c:parameter[@name="O_ERROR_CODE"]')[0];
        if($sxe->xpath('//c:parameter[@name="O_ERROR_DESCRIPTION"]'))
            $this->O_ERROR_DESCRIPTION = $sxe->xpath('//c:parameter[@name="O_ERROR_DESCRIPTION"]')[0];

        if($sxe->xpath('//c:errorDescription'))
            $this->errorDescription = $sxe->xpath('//c:errorDescription')[0];

        return true;
    }

    private function authenticate($username,$password)
    {
        //user authentication logic goes here. 
        return ($username == 'AAA' && $password == 'AAAB');
    }

    private function queryCore($data){
        $processTypeID = '500';
        $sourceID = '1111111';
        $username ='BBB';
        $password = 'BBBCD';    
        $externalReference = $data['externalReference'];        
        $processFlag = $data['processFlag']; 
        $I_TRANSACTION_ID = $data['I_TRANSACTION_ID'];

        $xml_core_request  = <<<EOD
            <?xml version="1.0" encoding="utf-8"?>
            <soap11:Envelope xmlns:soap11="http://schemas.xmlsoap.org/soap/envelope/" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            xmlns:xs="http://www.w3.org/2001/XMLSchema" 
            xmlns:tns="http://sdf.cellc.net/" 
            xmlns:ns="http://sdf.cellc.net/commonDataModel" 
            xmlns="http://sdf.cellc.net/">
                <soap11:Body>
                    <ns:SDF_Data>
                        <ns:header>
                        <ns:processTypeID>$processTypeID</ns:processTypeID>
                            <ns:externalReference>$externalReference</ns:externalReference>
                            <ns:sourceID>$sourceID</ns:sourceID>
                            <ns:username>$username</ns:username>
                            <ns:password>$password</ns:password>
                            <ns:processFlag>$processFlag</ns:processFlag>
                        </ns:header>
                        <ns:parameters>
                            <ns:parameter name="I_TRANSACTION_ID">$I_TRANSACTION_ID</ns:parameter>
                        </ns:parameters>
                    </ns:SDF_Data>
                </soap11:Body>
            </soap11:Envelope>
        EOD;      
        
        //core url
        $URL = "http://localhost/xml/core.php";

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_core_request");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        if($result){
            return $this->extrateCoreXMLData($result);
        }

        $this->errorDescription = 'Request not proceesed (CORE APP FAILD)';

        return false;

    }

}

?>