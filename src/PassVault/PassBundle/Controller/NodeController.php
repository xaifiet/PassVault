<?php

namespace PassVault\PassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{


    protected function getChildrenNodes(&$nodes, $parentId, $list)
    {
//        $classes = array(
//            'PassVault\PassBundle\Entity\Organization',
//            'PassVault\PassBundle\Entity\Folder',
//        );

        foreach ($list as $item) {
//            if (!in_array(get_class($item), $classes)) {
//                continue;
//            }

            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $nodes[] = $item;
                $this->getChildrenNodes($nodes, $item->getId(), $list);
            }
        }
    }

    public function indexAction(Request $request, $id = null)
    {

        $formTypes = array(
            'PassVault\PassBundle\Entity\Organization' => 'organization',
            'PassVault\PassBundle\Entity\Folder' => 'folder',
            'PassVault\PassBundle\Entity\Password' => 'passvault'
        );

        // fetching entities from database
        $list = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->findBy(

            array(),
            array('name' => 'ASC')
        );

        // Initialize nodes array
        $nodes = array();

        // Ordering nodes to get a tree
        $this->getChildrenNodes($nodes, null, $list);

        if (is_null($id)) {
            $node = null;
            $form = null;
        } else {
            $node = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($id);
            $form = $this->createForm($formTypes[get_class($node)], $node, array(
                'action' => $request->getUri(),
                'method' => 'POST'
            ))->createView();
        }

        // rendering the tree
        return $this->render('PassVaultPassBundle:Node:index.html.twig', array(
            'nodes' => $nodes,
            'node' => $node,
            'form' => $form
        ));
    }

}
