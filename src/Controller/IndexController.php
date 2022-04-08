<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $posts=$em->getRepository(Post::class)->findBy([],['created_at'=>'DESC']);

        $posts = $paginator->paginate($posts, $request->query->getInt('page',1), limit: 2);

        return $this->render('index/index.html.twig', ['posts'=>$posts,
        ]);
    }
}
