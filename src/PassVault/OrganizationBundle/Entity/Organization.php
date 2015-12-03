<?php

namespace PassVault\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="pv_organizations")
 */
class Organization extends \PassVault\NodeBundle\Entity\Node
{

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     */
    private $keyFile;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\TeamBundle\Entity\Team", mappedBy="organization", cascade={"all"}, orphanRemoval=true)
     **/
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="OrganizationUser", mappedBy="organization", cascade={"all"}, orphanRemoval=true)
     **/
    private $users;

    private $hash;

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


    /**
     * Set keyFile
     *
     * @param string $keyFile
     *
     * @return Organization
     */
    public function setKeyFile($keyFile)
    {
        $this->keyFile = $keyFile;

        return $this;
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
     * Add team
     *
     * @param \PassVault\TeamBundle\Entity\Team $team
     *
     * @return Organization
     */
    public function addTeam(\PassVault\TeamBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \PassVault\TeamBundle\Entity\Team $team
     */
    public function removeTeam(\PassVault\TeamBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add user
     *
     * @param \PassVault\OrganizationBundle\Entity\OrganizationUser $user
     *
     * @return Organization
     */
    public function addUser(\PassVault\OrganizationBundle\Entity\OrganizationUser $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \PassVault\OrganizationBundle\Entity\OrganizationUser $user
     */
    public function removeUser(\PassVault\OrganizationBundle\Entity\OrganizationUser $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
