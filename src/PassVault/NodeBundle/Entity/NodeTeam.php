<?php

namespace PassVault\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_nodes_teams")
 */
class NodeTeam
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $node;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\PassVault\TeamBundle\Entity\Team", inversedBy="nodes")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $team;

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
     * @return NodeTeam
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
     * Set node
     *
     * @param \PassVault\NodeBundle\Entity\Node $node
     *
     * @return NodeTeam
     */
    public function setNode(\PassVault\NodeBundle\Entity\Node $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \PassVault\NodeBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set team
     *
     * @param \PassVault\TeamBundle\Entity\Team $team
     *
     * @return NodeTeam
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
}
