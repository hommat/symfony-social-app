<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
  /**
   * @Route("/", name="home", methods={"GET"})
   */
  public function home()
  {
    return $this->render('post/home.html.twig');
  }
}
