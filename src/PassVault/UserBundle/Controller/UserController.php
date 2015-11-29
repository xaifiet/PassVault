<?php

namespace PassVault\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use PassVault\PassBundle\Entity\Vault;

class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render('PassVaultUserBundle:User:login.html.twig');
    }

    public function registerAction(Request $request)
    {
        if (!empty($request->get('email'))) {

            $userManager = $this->get('fos_user.user_manager');

            $characters = 'abcdef0123456789';
            $token = '';
            for ($i = 0; $i < 60; $i++) {
                $token .= $characters[rand(0, strlen($characters) - 1)];
            }

            $user = $userManager->createUser();
            $user->setFirstname($request->get('firstname'));
            $user->setLastname($request->get('lastname'));
            $user->setEmail($request->get('email'));
            $user->setUsername($request->get('email'));
            $user->setPlainPassword($request->get('password'));
            $user->getConfirmationToken($token);
            $userManager->updateUser($user);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('passvault_homepage');

        }

        return $this->render('PassVaultUserBundle:User:register.html.twig');
    }

    public function confirmationAction($token)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        $user->setEnabled(true);

        $em = $this->getDoctrine()->getManager();


        $vault = new Vault();
        $vault->setName($user->getFirstname().' '.$user->getLastname());
        $vault->setOwner($user);


        $em->persist($user);
        $em->persist($vault);

        $em->flush();

        return $this->redirectToRoute('passvault_homepage');
    }
}
