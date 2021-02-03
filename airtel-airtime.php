<?php
$date = date('d/m/Y H:i:s');
$response = <<<XML
<?xml version="1.0"?>
<COMMAND> 
<TYPE>EXRCTRFRESP</TYPE>    		
<TXNSTATUS>200</TXNSTATUS >
<DATE>$date</DATE>
<EXTREFNUM>123456789</EXTREFNUM>
<TXNID>R080912.1212.1234</TXNID>
<MESSAGE>Transaction Successful</MESSAGE>
</COMMAND>
XML;
	
echo ($response);