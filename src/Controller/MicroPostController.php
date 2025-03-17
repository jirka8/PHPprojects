<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use Doctrine\ORM\EntityManager;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, subject: 'post')]
    public function show(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuthor($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();
            
            $this->addFlash('success', 'Post created successfully!');
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/micro-post/{id}/edit', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, subject: 'post')]
    public function edit(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MicroPostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();
            
            $this->addFlash('success', 'Post was edited successfully!');
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/edit.html.twig', [
            'form' => $form,
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    #[IsGranted('ROLE_COMMENTATOR')]
    public function addComment(MicroPost $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();
            
            $this->addFlash('success', 'Your comment was added successfully!');
            return $this->redirectToRoute(
                'app_micro_post_show', 
                ['id' => $post->getId()]
            );
        }

        return $this->render('micro_post/comment.html.twig', [
            'form' => $form, 
            'post' => $post,
        ]);
    }
}
