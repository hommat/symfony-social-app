<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Post;
use App\Form\Type\PostType;
use App\Repository\PostRepository;

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
   * @Route("/posts/{id}", name="app_posts_post", methods={"GET"})
   */
  public function single(int $id): Response
  {
    $post = $this->postRepository->getSinglePost($id);
    if (!$post) {
      throw $this->createNotFoundException();
    }

    return $this->render('post/single.html.twig', ['post' => $post]);
  }

  /**
   * @Route("/posts/{id}/delete", name="app_posts_delete", methods={"POST"})
   */
  public function delete(Request $request, int $id): Response
  {
    $post = $this->postRepository->findOneById($id);

    if (!$post) {
      throw $this->createNotFoundException();
    }

    $submittedToken = $request->request->get('token');
    $isTokenvalid = $this->isCsrfTokenValid('delete-item', $submittedToken);
    $isUserOwner = $post->getAuthor()->getId() == $this->getUser()->getId();

    if (!$isTokenvalid || !$isUserOwner) {
      throw $this->createAccessDeniedException();
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($post);
    $entityManager->flush();

    return $this->render('post/delete.html.twig');
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
