<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HelloController extends Controller
{
   /**
     * Hello world web service, display name when called #AppBundle\Controller\HelloService.php
     * @param string $name
     * @return mixed
     */
    public function hello($name)
    {
        return 'Hello ' . $name . ', server time is ' . date ('H:i:s');
    }
}
