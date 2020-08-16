<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
  /**
   * @Route("/register", name="register", methods={"GET", "POST"})
   */
  public function register(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $user = $form->getData();

      return $this->redirectToRoute("home");
    }


    return $this->render('user/create.html.twig', ['form' => $form->createView()]);
  }
}
