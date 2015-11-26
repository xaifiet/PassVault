<?php

namespace PassVault\UserBundle\Security\Authorization\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use PassVault\UserBundle\Entity\Team;

class TeamVoter implements VoterInterface
{

    private $container;

    private $roles = array(
        'ROLE_USER' => 1,
        'ROLE_ADMINISTRATOR' => 2
    );

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array_keys($this->roles));
    }

    public function supportsClass($class)
    {
        return ($class == 'PassVault\UserBundle\Entity\Team');
    }

    function vote(TokenInterface $token, $team, array $attributes)
    {

        if (!($team instanceof Team)) {
            return self::ACCESS_ABSTAIN;
        }

        if (!in_array($attributes[0], $this->roles)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        foreach ($team->getUsers() as $teamUser) {
            if ($teamUser->getUser() == $user
                && $this->roles[$teamUser->getRole()] >= $this->roles[$attributes[0]]) {
                return self::ACCESS_GRANTED;
            }
        }

        return self::ACCESS_DENIED;
    }
}