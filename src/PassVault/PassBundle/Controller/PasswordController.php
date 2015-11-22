<?php

namespace PassVault\PassBundle\Controller;

use PassVault\PassBundle\Entity\Password;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PasswordController extends Controller
{

    public function addAction(Request $request)
    {
        $password = new Password();

        $form = $this->createForm('passvault', $password, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($password);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_password_edit', array('id' => $password->getId()));
        }

        return $this->render('PassVaultPassBundle:Password:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $password,
        ));
    }

    public function editAction(Request $request, $id)
    {
        $password = $this->getDoctrine()->getRepository('PassVaultPassBundle:Password')->find($id);

        $form = $this->createForm('passvault', $password, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($password);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_password_edit', array('id' => $password->getId()));
        }

        return $this->render('PassVaultPassBundle:Password:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $password,
        ));
    }

}
