<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(
        #[CurrentUser] ?User $user,
        AuthenticationUtils $utils
    ): Response
    {
        if ($user) {
            return $this->redirectToRoute('app_micro_post');
        }

        $lastUsername = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();

        if ($error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('login/index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
    }
}
