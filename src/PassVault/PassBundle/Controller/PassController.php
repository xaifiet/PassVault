<?php

namespace PassVault\PassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PassController extends Controller
{
    public function indexAction()
    {
        return $this->render('PassVaultPassBundle:Pass:index.html.twig');
    }
}
