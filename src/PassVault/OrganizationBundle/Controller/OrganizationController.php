<?php

namespace PassVault\OrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrganizationController extends Controller
{

    public function indexAction($id)
    {
        return $this->render('PassVaultOrganizationBundle:Default:index.html.twig');
    }

    public function settingsAction($id)
    {

        return $this->render('');
    }

}
