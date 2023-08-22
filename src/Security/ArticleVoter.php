<?php
namespace App\Security;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArticleVoter extends Voter
{
// these strings are just invented: you can use anything
const DELETE = 'delete';
const EDIT = 'edit';
private $security;
public function __construct(Security $security)
{
    $this->security = $security;
}
protected function supports(string $attribute, mixed $subject): bool
{
    // if the attribute isn't one we support, return false
    if (!in_array($attribute, [self::DELETE, self::EDIT])) {
        return false;
    }
    // only vote on `Article` objects
    if (!$subject instanceof Article) {
        return false;
    }
    return true;
}
protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
{
    // on récupere l'utilisateur à partir du token
    $user = $token->getUser();

    if (!$user instanceof User) {
    // the user must be logged in; if not, deny access
        return false;
    }
    // on vérifie si le user est admin
    if($this->security->isGranted('ROLE_ADMIN')) return true;

    //on vérifie les permissions
    switch ($attribute){
        case self::EDIT:
            return $this->canEdit($subject,$user);
        case self::DELETE:
            return $this->canDelete();
    }
// you know $subject is a Post object, thanks to `supports()`
/** @var Article $article   */
    return match($attribute) {
    self::DELETE => $this->canDelete(),
    self::EDIT => $this->canEdit($subject,$user),
    default => throw new \LogicException('This code should not be reached!')
};
}
private function canDelete(): bool
{
    return $this->security->isGranted('ROLE_ADMIN');
}
private function canEdit(Article $article, User $user): bool
{
    if($this->security->isGranted('ROLE_ADMIN') ||  $user === $article->getUser()) {
        return true;
    }
    return false;
}
}