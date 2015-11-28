<?php

namespace PassVault\PassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vp_vaults")
 */
class Vault extends \PassVault\PassBundle\Entity\Node
{

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $keyFile;

    private $hash;

    protected $icon = 'fa fa-lock';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->keyFile = md5(rand().microtime());

        $characters = 'abcdef0123456789';
        $this->hash = '';
        for ($i = 0; $i < 60; $i++) {
            $this->hash .= $characters[rand(0, strlen($characters) - 1)];
        }
    }

    public function getKey()
    {
        return $this->hash;
    }

    /**
     * Get keyFile
     *
     * @return string
     */
    public function getKeyFile()
    {
        return $this->keyFile;
    }

    /**
     * Set keyFile
     *
     * @param string $keyFile
     *
     * @return Password
     */
    public function setKeyFile($keyFile)
    {
        $this->keyFile = $keyFile;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Password
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $hash;
    }

}
