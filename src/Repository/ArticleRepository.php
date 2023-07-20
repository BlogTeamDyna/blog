<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class  ArticleRepository extends EntityRepository
{
    public function getByTags($tags): Query
    {
        $ids = [];

        foreach ($tags as $tag) {
            $ids[] = $tag->getId();
        }

        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery();
    }

    public function getAll(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }

}
