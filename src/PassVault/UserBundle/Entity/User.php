<?php

namespace PassVault\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 * @ORM\Table(name="pv_users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
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
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Firstname does not contain numbers"
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(),
     * @Assert\Length(min=2),
     * @Assert\Length(max=50),
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Lastname does not contain numbers"
     * )
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="TeamUser", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    private $teamUsers;

    public function __construct()
    {
        parent::__construct();
        $this->teamUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getFullName()
    {
        return $this->getFirstname().' '.$this->lastname;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata
            ->addPropertyConstraint('password', new Assert\Length(array(
                'min' => 8,
                'minMessage' => 'Your password must contain at least 8 characters'
            )))
            ->addPropertyConstraint('plainPassword', new Assert\Length(array(
                'min' => 8,
                'minMessage' => 'Your password must contain at least 8 characters'
            )))
        ;
    }

    /**
     * @param $email
     */
    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
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
     * Add teamUser
     *
     * @param \PassVault\UserBundle\Entity\TeamUser $teamUser
     *
     * @return User
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
