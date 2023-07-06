<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getByTags($tag): array
    {
//        $entityManager = $this->getEntityManager();
//
//        $query = $entityManager->createQuery(
//            'SELECT *
//                FROM App\Entity\Article p
//                JOIN p.article_tag a
//                WHERE a.tag = :tag
//                '
//        )->setParameter('tag', $tag);
//
//        return $query->getResult();

        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t.id = :tagId')
            ->setParameter('tagId', $tag->getId())
            ->getQuery()
            ->getResult()
        ;

    }
}
