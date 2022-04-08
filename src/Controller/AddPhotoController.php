<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\UploadPhotoType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Scalar\MagicConst\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class AddPhotoController
 * @package App/Controller
 * @IsGranted("ROLE_USER")
 */
class AddPhotoController extends AbstractController
{
    #[Route('/add/photo', name: 'app_add_photo')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        if ($this->getUser()==false)
        {
            $this->addFlash('error','Zaloguj się aby dodać zdjęcie.');
        }

        $addPhotoForm=$this->createForm(UploadPhotoType::class);
        $addPhotoForm->handleRequest($request);

        if($addPhotoForm->isSubmitted() && $addPhotoForm->isValid())
        {
            if ($this->getUser())
            {
                try
                {
                    /** @var UploadedFile  $photoFileName */
                    $photoFileName=$addPhotoForm->get('filename')->getData();
                    if($photoFileName)
                    {
                        $originalFileName=pathinfo($photoFileName->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFileName=transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',$originalFileName);
                        $newFileName = $safeFileName.'-'.uniqid().'.'.$photoFileName->guessExtension();
                        $photoFileName->move('photos/hosting',$newFileName);

                        $entityAddPhoto = new Photo();
                        $entityAddPhoto->setFilename($newFileName);
                        $entityAddPhoto->setWeight($addPhotoForm->get('weight')->getData());
                        $entityAddPhoto->setLength($addPhotoForm->get('length')->getData());
                        $entityAddPhoto->setType($addPhotoForm->get('type')->getData());
                        $entityAddPhoto->setName($this->getUser()->getName());
                        $entityAddPhoto->setUserId($this->getUser());
                        $entityAddPhoto->setUploadedAt(new \DateTime());

                        $em->persist($entityAddPhoto);
                        $em->flush();
                        $this->addFlash('success','Twoje zdjęcie zostało dodane.');
                    }

                }
                catch(\Exception $e)
                {
                    $this->addFlash('error','Coś poszło nie tak.');
                }
            }
        }
        if($addPhotoForm->isSubmitted() && !($addPhotoForm->isValid()))
        {
            $this->addFlash('error','Wprowadź poprawne dane.');

        }







        $addPhotoForm=$this->createForm(UploadPhotoType::class);
        return $this->render('add_photo/index.html.twig', [
            'controller_name' => 'AddPhotoController','addPhotoForm'=>$addPhotoForm->createView(),
        ]);
    }
}
