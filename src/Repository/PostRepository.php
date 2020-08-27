<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class PostRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Post::class);
  }

  public function getListPosts()
  {
    $qb = $this
      ->createQueryBuilder('post')
      ->select('post', 'author.username')
      ->innerJoin('post.author', 'author');

    return $qb->getQuery()->getScalarResult();
  }
}
