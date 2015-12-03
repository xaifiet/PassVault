<?php

namespace PassVault\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_teams")
 */
class Team
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(),
     * @Assert\Length(min=2),
     * @Assert\Length(max=50),
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="\PassVault\OrganizationBundle\Entity\Organization", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $organization;


    /**
     * @ORM\OneToMany(targetEntity="TeamUser", mappedBy="team", cascade={"all"}, orphanRemoval=true)
     **/
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nodes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set organization
     *
     * @param \PassVault\OrganizationBundle\Entity\Organization $organization
     *
     * @return Team
     */
    public function setOrganization(\PassVault\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \PassVault\OrganizationBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Add user
     *
     * @param \PassVault\TeamBundle\Entity\TeamUser $user
     *
     * @return Team
     */
    public function addUser(\PassVault\TeamBundle\Entity\TeamUser $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \PassVault\TeamBundle\Entity\TeamUser $user
     */
    public function removeUser(\PassVault\TeamBundle\Entity\TeamUser $user)
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
