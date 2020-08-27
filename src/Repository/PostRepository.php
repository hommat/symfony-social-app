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
    return $this->getPostQueryBuilder()->getQuery()->getScalarResult();
  }

  public function getSinglePost(int $id)
  {
    return $this
      ->getPostQueryBuilder()
      ->where('post.id = :id')
      ->setParameter('id', $id)
      ->getQuery()
      ->getOneOrNullResult();
  }

  public function getPostQueryBuilder()
  {
    $qb = $this
      ->createQueryBuilder('post')
      ->select('post.id', 'post.title', 'post.content', 'post.createdAt', 'author.username')
      ->innerJoin('post.author', 'author');

    return $qb;
  }
}
