<?php

namespace App\Controller;

use Dom\Entity;
use App\Entity\User;
use App\Entity\Comment;
use PhpParser\Node\Name;
use App\Entity\MicroPost;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created' => '2024/06/12'],
        ['message' => 'Hi', 'created' => '2024/04/12'],
        ['message' => 'Bye!', 'created' => '2021/05/12']
    ];

    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /*$user = new User();
        $user->setEmail('email@email.com');
        $user->setPassword('password');
        
        $profile = new UserProfile();
        $profile->setUser($user);
        $entityManager->persist($profile);
        $entityManager->flush();*/

        /*$post = new MicroPost();
        $post->setTitle('Some random title');
        $post->setText('Some random text');
        $post->setDate(new \DateTime());*/

        //$post = $entityManager->getRepository(MicroPost::class)->find(3);
        //$post->getComments()->count();
        //dd($cnt);
        
        /*$comment = new Comment();
        $comment->setText('Some random comment text');
        $comment->setPost($post);
        $entityManager->persist($comment);
        $entityManager->flush();*/

        return $this->render(
            'hello/index.html.twig', 
            [
            'messages' => $this->messages,
            'limit' => 3,
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id)
    {
        return $this->render(
            'hello/show_one.html.twig', 
            [
            'message' => $this->messages[$id],
            ]
        );
    }
}