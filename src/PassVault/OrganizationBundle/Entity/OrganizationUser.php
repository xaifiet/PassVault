<?php

namespace PassVault\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_organizations_users")
 */
class OrganizationUser
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $organization;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\PassVault\UserBundle\Entity\User", inversedBy="organizations")
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
     * @return OrganizationUser
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
     * Set organization
     *
     * @param \PassVault\OrganizationBundle\Entity\Organization $organization
     *
     * @return OrganizationUser
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
     * Set user
     *
     * @param \PassVault\UserBundle\Entity\User $user
     *
     * @return OrganizationUser
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
