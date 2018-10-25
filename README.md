symfony-soap-server
===================

A simple HelloWordl SOAP server implementation using Zend\SOAP and Symfony 3.4

Based on this old tutorial (Symfony 2.4) : 
http://www.techtonet.com/symfony-create-a-soap-server-with-zend-soap/

How to use ?
===================

Clone this repo : 
```
$ git clone https://github.com/changuelsami/symfonySoapServer.git
```

Move to the new created folder :
```
$ cd symfonySoapServer
```

Run composer install : 
```
$ composer install
```

Run server : 
```
$ php bin/console server:run
```

To see the WSDL file go to this URL : 
http://127.0.0.1:8000/soap/hello?wsdl

You can use Wizdler to browse the WSDL and test it : 
https://chrome.google.com/webstore/detail/wizdler/oebpmncolmhiapingjaagmapififiakb

This is the client sample code : 
```
$client = new SoapClient(
    'http://127.0.0.1:8001/soap/hello?wsdl',  
    ['cache_wsdl' => 0]  /* very important */
);

try {
    $response = $client->hello("John DOE");
    echo "\n Response : $response \n";

} catch (SoapFault $fault) {
    echo "Error: " . $fault->faultcode . ": " . $fault->getMessage() . "\n";
    var_dump($fault);
}
```