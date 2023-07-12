<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getByTags($tags): array
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
        $ids = [];

        foreach ($tags as $tag){
            $ids[] = $tag->getId();

        } dd($ids);

        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t.id = :tagId')
            ->setParameter('tagId', $tag->getId())
            ->getQuery()
            ->getResult()
        ;

    }
}
