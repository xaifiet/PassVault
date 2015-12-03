<?php

namespace PassVault\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_teams_users")
 */
class TeamUser
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $team;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\PassVault\UserBundle\Entity\User", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(),
     */
    protected $role;


    /**
     * Set role
     *
     * @param string $role
     *
     * @return TeamUser
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set team
     *
     * @param \PassVault\TeamBundle\Entity\Team $team
     *
     * @return TeamUser
     */
    public function setTeam(\PassVault\TeamBundle\Entity\Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \PassVault\TeamBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set user
     *
     * @param \PassVault\UserBundle\Entity\User $user
     *
     * @return TeamUser
     */
    public function setUser(\PassVault\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PassVault\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
