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
    private $teamUsers;

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
     * Add teamUser
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $teamUser
     *
     * @return Team
     */
    public function addTeamUser(\PassVault\UserBundle\Entity\TeamUser $teamUser)
    {
        $this->teamUsers[] = $teamUser;

        return $this;
    }

    /**
     * Remove teamUser
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $teamUser
     */
    public function removeTeamUser(\PassVault\UserBundle\Entity\TeamUser $teamUser)
    {
        $this->teamUsers->removeElement($teamUser);
    }

    /**
     * Get teamUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamUsers()
    {
        return $this->teamUsers;
    }
}
