<?php

namespace App\Controller;

use App\Entity\FisheryReservations;
use App\Form\FisheryReservationsFormType;
use App\Repository\FisheryReservationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FisheryReservationsController extends AbstractController
{
    #[Route('/reservations', name: 'app_fishery_reservations')]
    public function index(Request $request, EntityManagerInterface $em, FisheryReservationsRepository $fisheryReservationsRepository): Response
    {
        \locale_set_default('pl');
        $reservationsForm=$this->createForm(FisheryReservationsFormType::class);
        $reservationsForm->handleRequest($request);

        $myReservations=$em->getRepository(FisheryReservations::class)->findBy([],['since_when'=>'ASC']);
        $currentDate=new \DateTime();


        if ($this->getUser()==false)
        {
            $this->addFlash('error','Zaloguj się aby dokonać rezerwacji.');
        }

        if ($reservationsForm->isSubmitted() && $reservationsForm->isValid())
        {
            if($this->getUser())
            {
                try
                {
                    $entityFisheryReservations = new FisheryReservations();
                    $entityFisheryReservations->setSinceWhen($reservationsForm->get('since_when')->getData());
                    $entityFisheryReservations->setPositionNr($reservationsForm->get('position_nr')->getData());
                    $entityFisheryReservations->setUntilWhen($reservationsForm->get('until_when')->getData());
                    $entityFisheryReservations->setReservedAt(new \DateTime());
                    $entityFisheryReservations->setUser($this->getUser());
                    $entityFisheryReservations->setName($this->getUser()->getName());
                    //DATA FROM FORM
                    $startDate=$reservationsForm->get('since_when')->getData();
                    $endDate=$reservationsForm->get('until_when')->getData();
                    $position_nr=$reservationsForm->get('position_nr')->getData();

                    //DATA FROM DATABASE
                    $isPossibleToBook=$fisheryReservationsRepository->dateValidator($position_nr,$startDate,$endDate);
                    if($endDate>$startDate && $isPossibleToBook==true && $startDate>=$currentDate)
                    {
                        $em->persist($entityFisheryReservations);
                        $em->flush();
                        $this->addFlash('success','Rezerwacja została złożona pomyślnie!');

                        return $this->redirectToRoute('app_fishery_reservations');

                    }
                    else
                        $this->addFlash('error','Wybrane stanowisko jest już zajęte w tym terminie.');



                }
                catch(\Exception $e)
                {
                $this->addFlash('error','Coś poszło nie tak.');
                }
            }

        }

        return $this->render('fishery_reservations/index.html.twig', [
            'reservationsForm' =>$reservationsForm->createView(),'myReservations'=>$myReservations,'currentDate'=>$currentDate,

        ]);
    }
}
