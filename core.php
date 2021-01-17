<?php
$xml_request = NULL;

//test for post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xml_request = trim(file_get_contents('php://input'));
}else{
    echo 'Method not allowed.'; die;
}

//test for post data
if(empty($xml_request)){ 
    echo 'Invalid request'; die;
}

header('Content-type: text/xml; charset=utf-8');

$coreApp = new CoreApplication($xml_request);
$xml_response  = <<<XML
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
        <SOAP-ENV:Body>
            <ns0:SDF_Data xmlns:ns0="http://sdf.cellc.net/commonDataModel" processID="">
                <ns0:header>
                    <ns0:processTypeID>$coreApp->processTypeID</ns0:processTypeID>
                    <ns0:externalReference>$coreApp->externalReference</ns0:externalReference>
                    <ns0:sourceID>$coreApp->sourceID</ns0:sourceID>
                    <ns0:username>$coreApp->username</ns0:username>
                    <ns0:password>$coreApp->password</ns0:password>
                    <ns0:processFlag>$coreApp->processFlag</ns0:processFlag>
                </ns0:header>
                <ns0:result>
                    <ns0:statusCode>$coreApp->statusCode</ns0:statusCode>
                    <ns0:errorCode>$coreApp->errorCode</ns0:errorCode>
                    <ns0:errorDescription>$coreApp->errorDescription</ns0:errorDescription>
                    <ns0:resultElements>
                        <ns0:parameter name="O_RECHARGE_STATUS">$coreApp->O_RECHARGE_STATUS</ns0:parameter>
                        <ns0:parameter name="O_RECHARGE_DESCRIPTION">$coreApp->O_RECHARGE_DESCRIPTION</ns0:parameter>
                        <ns0:parameter name="O_RESULT">$coreApp->O_RESULT</ns0:parameter>
                        <ns0:parameter name="O_ERROR_CODE">$coreApp->O_ERROR_CODE</ns0:parameter>
                        <ns0:parameter name="O_ERROR_DESCRIPTION">$coreApp->O_ERROR_DESCRIPTION</ns0:parameter>
                    </ns0:resultElements>
                </ns0:result>
            </ns0:SDF_Data>
        </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
    XML;

echo $xml_response;

class CoreApplication 
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

    // Constructor 
    public function __construct($xml_request)
    { 

        $input_data = $this->extrateXMLData($xml_request);        
        if($input_data){
            $this->main($input_data);
        }else{
            $this->errorDescription = 'invalid Request (not a valid XML)';
        }
        
    }

    private function main($input_data)
    {
        $this->processTypeID = $input_data['processTypeID'];
        $this->externalReference = $input_data['externalReference'];
        $this->sourceID = $input_data['sourceID'];
        $this->username = $input_data['username'];
        $this->password = $input_data['password'];
        $this->processFlag = $input_data['processFlag'];

        $this->statusCode = $this->statusCode;
        $this->errorCode = $this->errorCode;
        $this->errorDescription = 'Successful Transaction';

        if($this->authenticate($this->username,$this->password)){
            $this->statusCode = '0';
            $this->errorCode = '0';
            $this->processResponse($input_data);        
        }else{
            $this->errorDescription = 'Invalid username ('.$this->username.') and password';
        }
    }

    private function processResponse($input_data)
    {
        $transaction_id = $input_data['I_TRANSACTION_ID'];
        $result = $this->loadTransactionData($transaction_id);
        if($result){
            $this->O_RECHARGE_STATUS = $result['O_RECHARGE_STATUS'];
            $this->O_RECHARGE_DESCRIPTION = $result['O_RECHARGE_DESCRIPTION'];
            $this->O_RESULT = $result['O_RESULT'];
            $this->O_ERROR_CODE = $result['O_ERROR_CODE'];
            $this->O_ERROR_DESCRIPTION = $result['O_ERROR_DESCRIPTION'];
            return true;
        }
        
        return false;        
    }
     
    private function authenticate($username,$password)
    {
        //authentication logic goes here
        return ($username == 'BBB' && $password == 'BBBCD');
    }

    private function loadTransactionData($transaction_id)
    {
        //the database logic goes here to fetch the needed data

        if($transaction_id != '1609620022827'){
            $this->errorDescription = 'invalid I_TRANSACTION_ID ('.$transaction_id.')';
            return false;
        }

        $data = array(
            'O_RECHARGE_STATUS'=>'SA',
            'O_RECHARGE_DESCRIPTION'=>'The request was successful',
            'O_RESULT'=>'SA',
            'O_ERROR_CODE'=>'SA',
            'O_ERROR_DESCRIPTION'=>'The request was successful',
        );

        return $data;
    }

    private function extrateXMLData($xml_request)
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

}
?>