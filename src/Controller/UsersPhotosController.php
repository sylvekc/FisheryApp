<?php

namespace App\Controller;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersPhotosController extends AbstractController
{
    #[Route('/photos', name: 'app_users_photos')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $usersPhotos=$em->getRepository(Photo::class)->findBy([],['uploaded_at'=>'DESC']);
        $usersPhotos = $paginator->paginate($usersPhotos, $request->query->getInt('page',1), limit: 9);

        return $this->render('users_photos/index.html.twig', [
            'controller_name' => 'UsersPhotosController', 'usersPhotos'=>$usersPhotos
        ]);
    }
}
