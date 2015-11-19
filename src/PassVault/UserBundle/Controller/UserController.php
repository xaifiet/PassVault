<?php

namespace PassVault\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render('PassVaultUserBundle:User:login.html.twig');
    }
}
