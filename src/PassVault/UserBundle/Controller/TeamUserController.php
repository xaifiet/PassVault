<?php

namespace PassVault\UserBundle\Controller;

use PassVault\UserBundle\Entity\TeamUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamUserController extends Controller
{

    public function addAction(Request $request, $id)
    {


        return $this->redirectToRoute('passvault_team_view', array('id' => $id));

    }

    public function deleteAction(Request $request, $id)
    {

        return $this->redirectToRoute('passvault_team_view', array('id' => $id));

    }

}
