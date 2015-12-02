<?php

namespace PassVault\PassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use PassVault\PassBundle\Entity\NodeTeam;
use PassVault\PassBundle\Entity\NodeUser;

class NodeController extends Controller
{

    private $types = array(
        'vault' => array(
            'class' => 'PassVault\PassBundle\Entity\Vault',
            'controller' => 'PassVaultPassBundle:Vault'
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
            if (!$this->isGranted('ROLE_READER', $item)) {
                continue;
            }
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
            $this->denyAccessUnlessGranted('ROLE_CONTRIBUTOR', $parent);
        }

        if (in_array($type, array_keys($this->types))) {
            $nodeController = $this->types[$type]['controller'] . ':add';
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

        $node = null;
        $nodeController = null;
        $error = array();
        if (!is_null($id)) {
            $node = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($id);
            if (is_null($node)) {
                $error = array(
                    'code' => 404,
                    'title' => 'This node does not exist',
                    'text' => 'Try to access nodes by the left menu or research'
                );
            } else if ($this->isGranted('ROLE_READER', $node)) {
                $nodeController = null;
                foreach ($this->types as $type) {
                    if ($type['class'] == get_class($node)) {
                        $nodeController = $type['controller'] . ':view';
                    }
                }
            } else {
                $node = null;
                $error = array(
                    'code' => 401,
                    'title' => 'You are not authorize to see this node',
                    'text' => 'Check your right'
                );
            }

        }

        if (is_null($nodeController)) {
            return $this->render('PassVaultPassBundle:Node:index.html.twig', array(
                'nodes' => $nodes,
                'error' => $error
            ));
        }

        return $this->forward($nodeController, array(
            'request' => $request,
            'nodes' => $nodes,
            'node' => $node
        ));
    }

    public function addTeamAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $node = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($id);

        $this->denyAccessUnlessGranted('ROLE_ADMINISTRATOR', $node);

        $team = $this->getDoctrine()->getRepository('PassVaultUserBundle:Team')->find($request->get('team'));

        $nodeteam = new NodeTeam();
        $nodeteam->setNode($node);
        $nodeteam->setTeam($team);
        $nodeteam->setRole($request->get('role'));
        $em->persist($nodeteam);
        $em->flush();

        return $this->redirectToRoute('passvault_node_view', array('id' => $id));
    }

    public function addUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $node = $this->getDoctrine()->getRepository('PassVaultPassBundle:Node')->find($id);

        $this->denyAccessUnlessGranted('ROLE_ADMINISTRATOR', $node);

        $email = $request->get('email');

        $user = $this->getDoctrine()->getRepository('PassVaultUserBundle:User')->findOneBy(array('email' => $email));

        if (is_null($user)) {
            $user = new User();
            $user->setEmail($email);
            $user->addRole('ROLE_USER');
            $user->setPlainPassword(md5($email));
            $em->persist($user);
        }

        $nodeuser = new NodeUser();
        $nodeuser->setNode($node);
        $nodeuser->setUser($user);
        $nodeuser->setRole($request->get('role'));
        $em->persist($nodeuser);
        $em->flush();

        return $this->redirectToRoute('passvault_node_view', array('id' => $id));
    }

    public function searchAction(Request $request) {

        $text = trim($request->get('text'));

        if (empty($text)) {
            $nodes = array();
        } else {
            $nodes = $this->getDoctrine()->getRepository('PassVaultPassBundle:Password')->search($request->get('text'));
        }

        return $this->render('PassVaultPassBundle:Node:search.html.twig', array(
            'nodes' => $nodes
        ));

    }

}