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
        if ($this->getParameter('allow_register') && !empty($request->get('email'))) {

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
            $user->setConfirmationToken($token);
            $userManager->updateUser($user);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('PassVault registration')
                ->setFrom($this->getParameter('mail_contact'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        '@PassVaultUser/Email/register.html.twig',
                        array('user' => $user)
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            return $this->render('PassVaultUserBundle:User:register-done.html.twig');

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

        return $this->render('PassVaultUserBundle:User:confirmation-done.html.twig');

    }

    public function forgotPasswordAction(Request $request)
    {

        if (!empty($request->get('email'))) {

            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->findUserByEmail($request->get('email'));

            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $password = '';
            for ($i = 0; $i < 10; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
            $user->setPlainPassword($password);

            $userManager->updateUser($user);

            $message = \Swift_Message::newInstance()
                ->setSubject('PassVault password generation')
                ->setFrom($this->getParameter('mail_contact'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'PassVaultUserBundle:Email:forgotpassword.html.twig',
                        array(
                            'user' => $user,
                            'password' => $password
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);


            return $this->render('PassVaultUserBundle:User:forgotpassword-done.html.twig', array(
                'user' => $user,
                'password' => $password
            ));

        }

        return $this->render('PassVaultUserBundle:User:forgotpassword.html.twig');

    }

}
