<?php

namespace PassVault\PassBundle\Controller;

use PassVault\PassBundle\Entity\Folder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends Controller
{
    public function addAction(Request $request)
    {
        $folder = new Folder();

        $form = $this->createForm('folder', $folder, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($folder);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_folder_edit', array('id' => $folder->getId()));
        }

        return $this->render('PassVaultPassBundle:Folder:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $folder,
        ));
    }

    public function editAction(Request $request, $id)
    {
        $folder = $this->getDoctrine()->getRepository('PassVaultPassBundle:Folder')->find($id);

        $form = $this->createForm('folder', $folder, array(
            'action' => $request->getUri(),
            'method' => 'POST'
        ));

        $form->handleRequest($request);
        $redirect = false;

        if ($form->isValid()) {
            if ($form->get('submit')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($folder);
                $em->flush();
                $redirect = true;
            }
        }

        if ($redirect) {
            return $this->redirectToRoute('passvault_folder_edit', array('id' => $folder->getId()));
        }

        return $this->render('PassVaultPassBundle:Folder:add.html.twig', array(
            'form' => $form->createView(),
            'node' => $folder,
        ));
    }

}
