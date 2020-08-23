<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Post;
use App\Form\Type\PostType;

/**
 * @IsGranted("ROLE_USER")
 */
class PostController extends AbstractController
{
  /**
   * @Route("/posts", name="app_posts", methods={"GET"})
   */
  public function list(): Response
  {
    return $this->render('post/list.html.twig');
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
