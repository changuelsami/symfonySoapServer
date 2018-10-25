<?php
/**
 * Declaration of the webservice's operations
 * 
 * This file is declared in app/config/services.yml (as a service)
 */
namespace AppBundle\Service;

class HelloService
{
    /**
     * Hello world web service, display name when called #AppBundle\Service\HelloService.php
     * @param string $name
     * @return mixed
     */
    public function hello($name)
    {
        return 'Hello ' . $name . ', server time is ' . date ('H:i:s');
    }
}
