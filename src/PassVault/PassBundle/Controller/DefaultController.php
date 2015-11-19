<?php

namespace PassVault\PassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PassVaultPassBundle:Default:index.html.twig', array('name' => $name));
    }
}
