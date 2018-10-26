<?php
/**
 * Simple SOAP Server - v1
 * 
 * Create a simple HelloWorld SOAP server. The main function (hello) is defined in HelloController 
 * which is a basic Controller. To publish a method of HelloController we've created this controller 
 * (SoapController) where we have one + two methods : 
 *  - First one  : how to publish all public methods of HelloController
 *  - Second one : how to generate the WSDL of the service
 *  - Third one  : how to call a method 
 * 
 * If you have a new controller to publish simply duplicate the first method and update these data : 
 *  - The route and it's name
 *  - The url
 *  - The instance of the new controller
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Needed to generate absolute URL
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

// Needed to create the SOAP server
use Zend\Soap;

class SoapController extends Controller
{  
    /**
     * To display the WSDL you have to call http://.../soap/hello?wsdl (see @Route)
     *
     * @Route("/soap/hello", name="soap_hello")
     */
    public function hello()
    {
        // This wil generate the absolute URL of the current action (end point) based on it's route name
        $theUri = $this->generateUrl('soap_hello', [], UrlGeneratorInterface::ABSOLUTE_URL);
        // This is the object to instanciate when the webservice is invoked, use any controller
        $theService = new HelloController();

        // Check if we should disply WSDL or execute the call
        if (isset($_GET['wsdl']))
            return $this->handleWSDL($theUri, $theService);
        else
            return $this->handleSOAP($theUri, $theService);
    }

    /**
     * return the WSDL
     */
    public function handleWSDL($uri, $class)
    {
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($class);
        $autodiscover->setUri($uri);

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8'); // WSDL is a XML content
        
        // Start Output Buffering, nothing will be displayed ...
        ob_start();
        // Handle Soap
        $autodiscover->handle();
        // ... Stop Output Buffering and get content into variable
        $response->setContent(ob_get_clean());
        return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class)
    {
        // Soap server
        $soap = new Soap\Server(null,
            array('location' => $uri,
                'uri' => $uri,
            ));
        $soap->setClass($class);

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
