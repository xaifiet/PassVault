<?php

namespace PassVault\PassBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\DependencyInjection\ContainerInterface;

use PassVault\PassBundle\Entity\Vault;

class VaultEventListener
{

    protected $directoryVar;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->directoryVar = $container->getParameter('directory_var');
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $node = $event->getEntity();

        if (!($node instanceof Vault)) {
            return;
        }

        $keyFile = $node->getKeyFile();

        $keyPath = rtrim($this->directoryVar, '/').'/'.$keyFile;

        if (file_exists($keyPath)) {
            $node->setHash(trim(file_get_contents($keyPath)));
        }
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $node = $event->getEntity();

        if (!($node instanceof Vault)) {
            return;
        }

        $keyFile = $node->getKeyFile();

        $keyPath = rtrim($this->directoryVar, '/').'/'.$keyFile;

        if (!file_exists($keyPath)) {
            if (!is_dir($this->directoryVar)) {
                mkdir ($this->directoryVar, 0700, true);
            }

            file_put_contents($keyPath, $node->getHash().chr(10));
        }
    }

}