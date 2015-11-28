<?php

namespace PassVault\PassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_nodes_users")
 */
class NodeUser
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $node;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\PassVault\UserBundle\Entity\User", inversedBy="assocNodes")
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
     * @return NodeUser
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
     * @param \PassVault\PassBundle\Entity\Node $node
     *
     * @return NodeUser
     */
    public function setNode(\PassVault\PassBundle\Entity\Node $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \PassVault\PassBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set user
     *
     * @param \PassVault\UserBundle\Entity\User $user
     *
     * @return NodeUser
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
