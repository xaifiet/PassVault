<?php

namespace PassVault\PassBundle\Twig;

class ClassExtension extends \Twig_Extension
{

    public function getTests()
    {
        return [
            new \Twig_SimpleTest( "instanceof", array($this, 'isInstanceof')),
        ];
    }

    /**
     * @param $var
     * @param $instance
     * @return bool
     */
    public function isInstanceof($var, $instance)
    {
        return $var instanceof $instance;
    }

    public function getName()
    {
        return 'class_extension';
    }

}