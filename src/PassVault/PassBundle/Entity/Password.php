<?php

namespace PassVault\PassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vp_passwords")
 */
class Password extends \PassVault\PassBundle\Entity\Node
{

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank()
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $account;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $keyFile;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     **/
    private $inherit = true;

    private $hash;

    protected $icon = 'fa fa-key';

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

    /**
     * Set passType
     *
     * @param string $passType
     *
     * @return Password
     */
    public function setPassType($passType)
    {
        $this->passType = $passType;

        return $this;
    }

    /**
     * Get passType
     *
     * @return string
     */
    public function getPassType()
    {
        return $this->passType;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Password
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return Password
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Password
     */
    public function setPassword($password)
    {
        $key = sha1($this->hash);
        $data = '';
        for ($i = 0; $i<strlen($password); $i++) {
            $kc = substr($key, ($i%strlen($key)) - 1, 1);
            $data .= chr(ord($password{$i})+ord($kc));
        }
        $this->password = base64_encode($data);

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        $key = sha1($this->hash);
        $password = '';
        $hash = base64_decode($this->password);
        for ($i = 0; $i<strlen($hash); $i++) {
            $kc = substr($key, ($i%strlen($key)) - 1, 1);
            $password .= chr(ord($hash{$i})-ord($kc));
        }

        return $password;
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
     * Set inherit
     *
     * @param boolean $inherit
     *
     * @return Node
     */
    public function setInherit($inherit)
    {
        $this->inherit = $inherit;

        return $this;
    }

    /**
     * Get inherit
     *
     * @return boolean
     */
    public function getInherit()
    {
        return $this->inherit;
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
