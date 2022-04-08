<?php

namespace App\Controller;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class MyPhotosController
 * @package App/Controller
 * @IsGranted("ROLE_USER")
 */

class MyPhotosController extends AbstractController
{
    #[Route('/my/photos', name: 'app_my_photos')]
    public function index(EntityManagerInterface $em): Response
    {
        $myPhotos=$em->getRepository(Photo::class)->findBy(['user_id'=>$this->getUser()],['uploaded_at'=>'DESC']);
        return $this->render('my_photos/index.html.twig', [
            'controller_name' => 'MyPhotosController',
            'myPhotos'=>$myPhotos
        ]);
    }

    #[Route('/my/photos/delete/{id}', name: 'app_my_photos_delete')]
    /**
     * @param int $id
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function myPhotoDelete(int $id, EntityManagerInterface $em)
    {
        $myPhoto=$em->getRepository(Photo::class)->find($id);
        if($this->getUser() == $myPhoto->getUserId())
        {
            $fileManager=new Filesystem();
            $fileManager->remove('photos/hosting'.$myPhoto->getFilename());
            if ($fileManager->exists('photos/hosting'.$myPhoto->getFilename()))
            {
                $this->addFlash('error','Nie udało się usunąć Zdjęcia');
            }
            else
            {
                $em->remove($myPhoto);
                $em->flush();
                $this->addFlash('success','Usunięto zdjęcie.');
            }
        }
        return $this->redirectToRoute('app_my_photos');
    }



}
