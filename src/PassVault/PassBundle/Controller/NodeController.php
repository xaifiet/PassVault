<?php

namespace PassVault\PassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NodeController extends Controller
{

    private $types = array(
        'organization' => array(
            'class' => 'PassVault\PassBundle\Entity\Organization',
            'controller' => 'PassVaultPassBundle:Organization'
        ),
        'folder' => array(
            'class' => 'PassVault\PassBundle\Entity\Folder',
            'controller' => 'PassVaultPassBundle:Folder'
        ),
        'password' => array(
            'class' => 'PassVault\PassBundle\Entity\Password',
            'controller' => 'PassVaultPassBundle:Password'
        )
    );

    protected function getNodes()
    {
        // fetching entities from database
        $list = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->findBy(
            array(),
            array('name' => 'ASC')
        );

        // Initialize nodes array
        $nodes = array();

        // Ordering nodes to get a tree
        $this->getChildrenNodes($nodes, null, $list);

        return $nodes;
    }

    protected function getChildrenNodes(&$nodes, $parentId, $list)
    {
        foreach ($list as $item) {
            $itemParentId = is_null($item->getParent()) ? null : $item->getParent()->getId();
            if ($itemParentId === $parentId) {
                $nodes[] = $item;
                $this->getChildrenNodes($nodes, $item->getId(), $list);
            }
        }
    }

    public function addAction(Request $request, $parent = null, $type)
    {

        $nodes = $this->getNodes();

        if (!is_null($parent)) {
            $parent = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($parent);
        }

        if (in_array($type, array_keys($this->types))) {
            $nodeController = $this->types[$type]['controller'].':add';
        } else {
            $nodeController = null;
        }

        if (is_null($nodeController)) {
            return $this->render('PassVaultPassBundle:Node:index.html.twig', array(
                'nodes' => $nodes
            ));
        }

        return $this->forward($nodeController, array(
            'request' => $request,
            'nodes' => $nodes,
            'parent' => $parent
        ));
    }

    public function viewAction(Request $request, $id = null)
    {

        $nodes = $this->getNodes();

        if (is_null($id)){
            $node = null;
            $nodeController = null;
        } else {
            $node = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($id);

            $nodeController = null;
            foreach ($this->types as $type) {
                if ($type['class'] == get_class($node)) {
                    $nodeController = $type['controller'].':view';
                }
            }
        }

        if (is_null($nodeController)) {
            return $this->render('PassVaultPassBundle:Node:index.html.twig', array(
                'nodes' => $nodes
            ));
        }

        return $this->forward($nodeController, array(
            'request' => $request,
            'nodes' => $nodes,
            'node' => $node
        ));
    }

}
