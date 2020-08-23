<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
}
