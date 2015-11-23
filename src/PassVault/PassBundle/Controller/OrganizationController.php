<?php

namespace PassVault\PassBundle\Controller;

use PassVault\PassBundle\Entity\Organization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrganizationController extends Controller
{
    public function addAction(Request $request, $parent, $nodes)
    {
        $node = new Organization();

        return $this->viewAction($request, $nodes, $node);
    }

    public function viewAction(Request $request, $nodes, $node)
    {

        $form = $this->createForm('organization', $node, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($node);
                $em->flush();

                return $this->redirectToRoute('passvault_node_view', array('id' => $node->getId()));
            }
        }

        return $this->render('PassVaultPassBundle:Organization:view.html.twig', array(
            'nodes' => $nodes,
            'node' => $node,
            'form' => $form->createView()
        ));
    }

}
