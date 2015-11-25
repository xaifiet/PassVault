<?php

namespace PassVault\UserBundle\Entity;

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
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(),
     * @Assert\Length(min=2),
     * @Assert\Length(max=50),
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="TeamUser", mappedBy="team", cascade={"all"}, orphanRemoval=true)
     **/
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\PassBundle\Entity\NodeTeam", mappedBy="team", cascade={"all"}, orphanRemoval=true)
     **/
    private $nodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teamUsers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add user
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $user
     *
     * @return Team
     */
    public function addUser(\PassVault\UserBundle\Entity\TeamUser $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $user
     */
    public function removeUser(\PassVault\UserBundle\Entity\TeamUser $user)
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


    /**
     * Add node
     *
     * @param \PassVault\PassBundle\Entity\NodeTeam $node
     *
     * @return Team
     */
    public function addNode(\PassVault\PassBundle\Entity\NodeTeam $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * Remove node
     *
     * @param \PassVault\PassBundle\Entity\NodeTeam $node
     */
    public function removeNode(\PassVault\PassBundle\Entity\NodeTeam $node)
    {
        $this->nodes->removeElement($node);
    }

    /**
     * Get nodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}
