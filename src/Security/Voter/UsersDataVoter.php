<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\UsersData;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UsersDataVoter.
 */
class UsersDataVoter extends Voter
{
    private Security $security;

    /**
     * EventVoter constructor.
     */
    public function __constructor(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['VIEW', 'EDIT', 'DELETE'])
            && $subject instanceof UsersData;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'VIEW':
                return $this->isAuthor($subject, $user);
                break;
            case 'EDIT':
                return $this->isAuthor($subject, $user);
                break;
            case 'DELETE':
                return $this->isAuthor($subject, $user);
                break;
            default:
                return false;
                break;
        }

        return false;
    }

    /**
     * @param $subject
     * @param \App\Entity\User $user
     * @return bool
     */
    private function isAuthor($subject, User $user): bool
    {
        return $subject->getAuthor() === $user;
    }
}
