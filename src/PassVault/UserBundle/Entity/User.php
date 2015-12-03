<?php

namespace PassVault\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_users")
 */
class User //implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email(message = "user.email.validator.Email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message = "user.firstname.validator.Notblank")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message = "user.lastname.validator.Notblank")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $token;

    /**
     * @ORM\Column(name="is_password_expired", type="boolean")
     */
    private $isPasswordExpired = 1;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(choices = {"ROLE_USER", "ROLE_ADMIN"}, message = "user.role.validator.Choice")
     */
    private $role = 'ROLE_USER';

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = 1;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\OrganizationBundle\Entity\OrganizationUser", mappedBy="user", cascade={"all"})
     **/
    private $organizations;

    /**
     * @ORM\OneToMany(targetEntity="\PassVault\TeamBundle\Entity\TeamUser", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    private $teams;

    public function __construct() {
        $this->salt = md5(uniqid(null, true));
        $this->role = 'ROLE_USER';
        $this->isActive = true;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->organizations = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    protected function generatePassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = '';
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, count($alphabet)-1);
            $pass[$i] = $alphabet[$n];
        }
        return $pass;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set isPasswordExpired
     *
     * @param boolean $isPasswordExpired
     *
     * @return User
     */
    public function setIsPasswordExpired($isPasswordExpired)
    {
        $this->isPasswordExpired = $isPasswordExpired;

        return $this;
    }

    /**
     * Get isPasswordExpired
     *
     * @return boolean
     */
    public function getIsPasswordExpired()
    {
        return $this->isPasswordExpired;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
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
     * @return User
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
     * Add organization
     *
     * @param \PassVault\OrganizationBundle\Entity\OrganizationUser $organization
     *
     * @return User
     */
    public function addOrganization(\PassVault\OrganizationBundle\Entity\OrganizationUser $organization)
    {
        $this->organizations[] = $organization;

        return $this;
    }

    /**
     * Remove organization
     *
     * @param \PassVault\OrganizationBundle\Entity\OrganizationUser $organization
     */
    public function removeOrganization(\PassVault\OrganizationBundle\Entity\OrganizationUser $organization)
    {
        $this->organizations->removeElement($organization);
    }

    /**
     * Get organizations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * Add team
     *
     * @param \PassVault\TeamBundle\Entity\TeamUser $team
     *
     * @return User
     */
    public function addTeam(\PassVault\TeamBundle\Entity\TeamUser $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \PassVault\TeamBundle\Entity\TeamUser $team
     */
    public function removeTeam(\PassVault\TeamBundle\Entity\TeamUser $team)
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
