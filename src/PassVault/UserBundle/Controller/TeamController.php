<?php

namespace PassVault\UserBundle\Controller;

use PassVault\UserBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{

    public function viewAction(Request $request, $id = null)
    {

        $teams = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->findBy(
            array(),
            array('name' => 'ASC')
        );

        if (is_null($id)) {
            $team = new Team();
        } else {
            $team = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->find($id);
        }

        $form = $this->createForm('team', $team, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->flush();
                return $this->redirectToRoute('passvault_team_view', array('id' => $team->getId()));
            }
        }

        return $this->render('PassVaultUserBundle:Team:view.html.twig', array(
            'teams' => $teams,
            'team' => $team,
            'form' => $form->createView()

        ));
    }

    public function deleteAction($id)
    {
        $team = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        return $this->redirectToRoute('passvault_team_index');
    }

}
