<?php

namespace PassVault\UserBundle\Controller;

use PassVault\UserBundle\Entity\Team;
use PassVault\UserBundle\Entity\TeamUser;
use PassVault\UserBundle\Entity\User;
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
            $this->denyAccessUnlessGranted('ROLE_USER', $team);
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

                $flg = false;
                $user = $this->getUser();
                if (!is_null($team->getUsers())) {
                    foreach ($team->getUsers() as $teamuser) {
                        if ($teamuser->getUser() == $user) {
                            $flg = true;
                            if ($teamuser->getRole() != 'ROLE_ADMIN') {
                                $teamuser->setRole('ROLE_ADMIN');
                                $em->persist($teamuser);
                            }
                        }
                    }
                }
                $em->flush();

                if (!$flg) {
                    $teamuser = new TeamUser();
                    $teamuser->setTeam($team);
                    $teamuser->setUser($user);
                    $teamuser->setRole('ROLE_ADMIN');
                    $em->persist($teamuser);
                    $em->flush();
                }

                return $this->redirectToRoute('passvault_team_view', array('id' => $team->getId()));
            }
        }

        return $this->render('PassVaultUserBundle:Team:view.html.twig', array(
            'teams' => $teams,
            'team' => $team,
            'form' => $form->createView()

        ));
    }

    public function inviteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $team = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->find($id);

        $this->denyAccessUnlessGranted('ROLE_ADMINISTRATOR', $team);

        $email = $request->get('email');

        $user = $this->getDoctrine()->getRepository('PassVaultUserBundle:User')->findOneBy(array('email' => $email));

        if (is_null($user)) {
            $user = new User();
            $user->setEmail($email);
            $user->addRole('ROLE_USER');
            $user->setPlainPassword(md5($email));
            $em->persist($user);
        }

        $teamuser = new TeamUser();
        $teamuser->setTeam($team);
        $teamuser->setUser($user);
        $teamuser->setRole($request->get('role'));
        $em->persist($teamuser);
        $em->flush();

        return $this->redirectToRoute('passvault_team_view', array('id' => $id));
    }

    public function deleteAction($id)
    {
        $team = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->find($id);

        $this->denyAccessUnlessGranted('ROLE_ADMINISTRATOR', $team);

        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
        $em->flush();

        return $this->redirectToRoute('passvault_team_index');
    }

}
