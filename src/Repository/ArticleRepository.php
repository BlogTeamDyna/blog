<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class  ArticleRepository extends EntityRepository
{
    public function getByTags($tags): Query
    {

        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t.id IN (:ids)')
            ->setParameter('ids', $tags)
            ->getQuery();
    }

    public function getAll(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();
    }

    public function searchByTitleAndDescription($searchData): Query
    {
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :search')
            ->orWhere('a.description LIKE :search')
            ->setParameter('search', '%'.$searchData.'%')
            ->getQuery();
    }

}
