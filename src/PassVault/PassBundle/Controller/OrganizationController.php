<?php

namespace PassVault\PassBundle\Controller;

use PassVault\PassBundle\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrganizationController extends Controller
{
    public function addAction(Request $request)
    {
        $organization = new Organization();

        $form = $this->createForm('organization', $organization, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($organization);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_organization_edit', array('id' => $organization->getId()));
        }

        return $this->render('PassVaultPassBundle:Organization:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $organization,
        ));
    }

    public function editAction(Request $request, $id)
    {
        $organization = $this->getDoctrine()->getRepository('PassVaultPassBundle:Organization')->find($id);

        $form = $this->createForm('organization', $organization, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($organization);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_organization_edit', array('id' => $organization->getId()));
        }

        return $this->render('PassVaultPassBundle:Organization:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $organization,
        ));
    }

}
