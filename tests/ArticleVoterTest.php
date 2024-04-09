<?php

namespace App\Tests;

use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use App\Security\ArticleVoter;
use App\Entity\Article;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class ArticleVoterTest extends TestCase
{
//    public function setUp(): void
//    {
//        $this->security = $this
//            ->getMockBuilder('Symfony\Bundle\SecurityBundle\Security')
//            ->disableOriginalConstructor()
//            ->getMock();
//    }

    public function testVoteOnAttribute(): void
    {
        // MOCKING
        $user = $this->createMock(User::class);

        $security = $this->createMock(Security::class);
        $security->method('isGranted')
            ->willReturnMap([
                ['ROLE_ADMIN', null, true],
                ['ROLE_USER', null, false],
                            ]);

        $token = $this->createMock(TokenInterface::class);
        $token->expects($this->any())
            ->method('getUser')
            ->willReturn($user);

        $articleVoter = new ArticleVoter($security);

        $article = new Article();
        $article->setUser($user);
        $userWithDeniedAccess = new User();

        $userWithDeniedAccess->setRoles(['ROLES_USER']);

        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $articleVoter->vote($token, $article, [ArticleVoter::EDIT]));
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $articleVoter->vote($token, $article, [ArticleVoter::DELETE]));
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $articleVoter->vote($token, $userWithDeniedAccess, [ArticleVoter::EDIT]));


    }
}
