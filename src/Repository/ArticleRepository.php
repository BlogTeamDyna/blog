<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class  ArticleRepository extends EntityRepository
{
    // SQl =
    public function getByTags($tags): Query
    {

        return $this->createQueryBuilder('a')
            ->join('a.tags', 't')
            ->where('t.id IN (:ids)')
            ->setParameter('ids', $tags)
            ->getQuery();
    }

// SQl = SELECT * FROM article a ORDER BY a.id DESC
    public function getAll(): Query
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();
    }

//  SQl = SELECT * FROM article WHERE article.title LIKE :search OR article.description LIKE :search
    public function searchByTitleAndDescription($searchData): Query
    {
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :search')
            ->orWhere('a.description LIKE :search')
            ->setParameter('search', '%'.$searchData.'%')
            ->getQuery();
    }

}
