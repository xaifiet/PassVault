<?php

namespace PassVault\PassBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use PassVault\PassBundle\Entity\Password;

class PasswordEventListener
{

    protected $directoryVar;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->directoryVar = $container->getParameter('directory_var');
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $password = $event->getEntity();

        if (!($password instanceof Password)) {
            return;
        }

        $keyFile = $password->getKeyFile();

        $keyPath = rtrim($this->directoryVar, '/').'/'.$keyFile;

        if (file_exists($keyPath)) {
            $password->setHash(file_get_contents($keyPath));
        }
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $password = $event->getEntity();

        if (!($password instanceof Password)) {
            return;
        }

        $keyFile = $password->getKeyFile();

        $keyPath = rtrim($this->directoryVar, '/').'/'.$keyFile;

        if (!file_exists($keyPath)) {
            if (!is_dir($this->directoryVar)) {
                mkdir ($this->directoryVar, 0700, true);
            }

            file_put_contents($keyPath, $password->getHash());
        }
    }

}