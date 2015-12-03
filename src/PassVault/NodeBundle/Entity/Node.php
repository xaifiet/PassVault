<?php

namespace PassVault\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="pv_nodes")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Node
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent", cascade={"all"})
     **/
    private $children;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="\PassVault\UserBundle\Entity\User", inversedBy="nodes", cascade={"all"})
     * @ORM\JoinColumn(nullable=false)
     **/
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="nodeTeam", mappedBy="node", cascade={"all"}, orphanRemoval=true)
     **/
    private $teams;

    protected $icon = null;

    /**
     * __construct function.
     *
     * @access public
     */
    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->updated = new \DateTime();
        if (is_null($this->created)) {
            $this->created = $this->updated;
        }
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
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
     * @return Node
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Node
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Node
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set parent
     *
     * @param \PassVault\NodeBundle\Entity\Node $parent
     *
     * @return Node
     */
    public function setParent(\PassVault\NodeBundle\Entity\Node $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \PassVault\NodeBundle\Entity\Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \PassVault\NodeBundle\Entity\Node $child
     *
     * @return Node
     */
    public function addChild(\PassVault\NodeBundle\Entity\Node $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \PassVault\NodeBundle\Entity\Node $child
     */
    public function removeChild(\PassVault\NodeBundle\Entity\Node $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set owner
     *
     * @param \PassVault\UserBundle\Entity\User $owner
     *
     * @return Node
     */
    public function setOwner(\PassVault\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \PassVault\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add team
     *
     * @param \PassVault\NodeBundle\Entity\nodeTeam $team
     *
     * @return Node
     */
    public function addTeam(\PassVault\NodeBundle\Entity\nodeTeam $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \PassVault\NodeBundle\Entity\nodeTeam $team
     */
    public function removeTeam(\PassVault\NodeBundle\Entity\nodeTeam $team)
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
}
