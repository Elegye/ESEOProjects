<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['PROJECT_EDIT', 'PROJECT_DELETE'])
            && $subject instanceof \App\Entity\Project;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'PROJECT_EDIT':
                return $this->canEdit($user, $subject);
                break;
            case 'PROJECT_DELETE':
                return $this->canDelete($user, $subject);
                break;
        }

        return false;
    }

    /**
     * Fonction privée permettant de savoir si un utilisateur peut modifier ou non un projet.
     * @param  User $user    Utilisateur
     * @param  Project $project Projet
     * @return boolean          TRUE ou FALSE
     */
    private function canEdit(\App\Entity\User $user, \App\Entity\Project $project){
        if($project->getUsers()->contains($user)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Fonction privée permettant de savoir si un utilisateur peut supprimer ou non un projet.
     * @param  User $user    Utilisateur
     * @param  Project $project Projet
     * @return boolean          TRUE ou FALSE
     */
    private function canDelete(\App\Entity\User $user, \App\Entity\Project $project){
        return $this->canEdit($user, $project);
    }
}
