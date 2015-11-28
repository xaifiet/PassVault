<?php

namespace PassVault\PassBundle\Security\Authorization\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use PassVault\PassBundle\Entity\Node;

class NodeVoter implements VoterInterface
{

    private $container;

    private $roles = array(
        'ROLE_READER' => 1,
        'ROLE_CONTRIBUTOR' => 2,
        'ROLE_ADMINISTRATOR' => 3
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
        return ($class == 'PassVault\PassBundle\Entity\Node');
    }

    function vote(TokenInterface $token, $node, array $attributes)
    {

        if (!($node instanceof Node)) {
            return self::ACCESS_ABSTAIN;
        }

        if (!in_array($attributes[0], array_keys($this->roles))) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();

        $parent = $node->getParent();
        if (!is_null($parent) &&
            !$this->container->get('security.authorization_checker')->isGranted($attributes, $parent)) {
            return self::ACCESS_DENIED;
        }

        if (method_exists($node, 'getInherit') && $node->getInherit()) {
            return self::ACCESS_GRANTED;
        }

        if ($node->getOwner() == $user) {
            return self::ACCESS_GRANTED;
        }

        foreach ($node->getUsers() as $nodeUser) {
            if ($nodeUser->getUser() == $user
                && $this->roles[$nodeUser->getRole()] >= $this->roles[$attributes[0]]) {
                return self::ACCESS_GRANTED;
            }
        }

        foreach ($user->getAssocTeams() as $team) {
            foreach ($node->getTeams() as $nodeTeam) {
                if ($nodeTeam->getTeam() == $team->getTeam() &&
                    $this->roles[$nodeTeam->getRole()] >= $this->roles[$attributes[0]]) {
                    return self::ACCESS_GRANTED;
                }
            }
        }

        return self::ACCESS_DENIED;
    }
}