<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Zend\Soap;

class SoapController extends Controller
{
    /**
     * The base URL of the web service
     * @var string
     */
    private $serverUrl;

    /**
     * Constructor
     */
    public function __construct() {
        $this->serverUrl = "http://" . $_SERVER['HTTP_HOST'];
    }
    
    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl
     * @Route("/soap/hello", name="soap_hello")
     */
    public function hello()
    {
        if (isset($_GET['wsdl']))
            return $this->handleWSDL($this->generateUrl('soap_hello'), 'hello_service');
        else
            return $this->handleSOAP($this->generateUrl('soap_hello'), 'hello_service');
    }


    /**
     * return the WSDL
     */
    public function handleWSDL($uri, $class)
    {
        $uri = $this->serverUrl . $uri;
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($this->get($class));
        $autodiscover->setUri($uri);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
        ob_start();

        // Handle Soap
        $autodiscover->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class)
    {
        $uri = $this->serverUrl . $uri;
        // Soap server
        $soap = new Soap\Server(null,
            array('location' => $uri,
                'uri' => $uri,
            ));
        $soap->setClass($this->get($class));

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }
}
