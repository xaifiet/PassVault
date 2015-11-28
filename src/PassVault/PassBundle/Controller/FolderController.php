<?php

namespace PassVault\PassBundle\Controller;

use PassVault\PassBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends Controller
{

    public function addAction(Request $request, $parent, $nodes)
    {
        $node = new Folder();

        if (!is_null($parent)) {
            $node->setParent($parent);
        }

        $node->setOwner($this->getUser());

        return $this->viewAction($request, $nodes, $node);
    }

    public function viewAction(Request $request, $nodes, $node)
    {

        $form = $this->createForm('folder', $node, array(
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

        return $this->render('PassVaultPassBundle:Folder:view.html.twig', array(
            'nodes' => $nodes,
            'node' => $node,
            'form' => $form->createView()
        ));

    }

}
