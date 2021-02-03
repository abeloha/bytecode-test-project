<?php
$date = date('d/m/Y H:i:s');
$response = <<<XML
<?xml version="1.0"?>
<COMMAND> 
<TYPE>EXRCSTATRESP</TYPE>    		
<TXNSTATUS>200</TXNSTATUS >
<DATE>$date</DATE>
<EXTREFNUM>123456789</EXTREFNUM>
<TXNID>R080912.1212.1234</TXNID>
<REQSTATUS>200</REQSTATUS>
<MESSAGE>Transaction number DL/05/000000015 to recharge 100 INR to 9810012345 is successful. Receiver transferred value 99 INR </MESSAGE>
</COMMAND>
XML;
	
echo ($response);