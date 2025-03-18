<?php

namespace App\Controller;

use App\Entity\MicroPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(
        MicroPost $post, 
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $currentUser = $this->getUser();
        $post->addLikedBy($currentUser);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(
        MicroPost $post, 
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $currentUser = $this->getUser();
        $post->removeLikedBy($currentUser);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }    
}
