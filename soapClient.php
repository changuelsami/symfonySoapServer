<?php
// WS Client
// Run this file from CLI : 
// $ php soapClient.php
$client = new SoapClient(
    'http://127.0.0.1:8001/soap/hello?wsdl',  
    ['cache_wsdl' => 0]  /* very important */
);

try {
    $response = $client->hello("Foobar H:" . date('H:i:s'));
    echo "\n Response : $response \n";

} catch (SoapFault $fault) {
    echo "Error: " . $fault->faultcode . ": " . $fault->getMessage() . "\n";
    var_dump($fault);
}

