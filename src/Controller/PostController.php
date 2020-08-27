<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Post;
use App\Form\Type\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @IsGranted("ROLE_USER")
 */
class PostController extends AbstractController
{
  private $postRepository;

  public function __construct(PostRepository $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  /**
   * @Route("/posts", name="app_posts", methods={"GET"})
   */
  public function list(): Response
  {
    $posts = $this->postRepository->getListPosts();

    return $this->render('post/list.html.twig', ['posts' => $posts]);
  }

  /**
   * @Route("/posts/{id}", methods={"GET"})
   */
  public function single(int $id): Response
  {
    $post = $this->postRepository->getSinglePost($id);
    if (!$post) {
      return $this->render('404/404.html.twig');
    }

    return $this->render('post/single.html.twig', ['post' => $post]);
  }

  /**
   * @Route("/posts/create", name="app_posts_create", methods={"GET", "POST"})
   */
  public function create(Request $request): Response
  {
    $post = new Post();

    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $post->setAuthor($this->getUser());

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($post);
      $entityManager->flush();

      return $this->redirectToRoute("app_posts");
    }

    return $this->render('post/create.html.twig', ['form' => $form->createView()]);
  }
}
