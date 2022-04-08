<?php

namespace App\Form;

use App\Entity\FisheryReservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class FisheryReservationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('position_nr', ChoiceType::class, [
                'choices'  => [
                'Stanowisko nr 1' => 1,
                'Stanowisko nr 2' => 2,
                'Stanowisko nr 3' => 3,
                'Stanowisko nr 4' => 4,
                'Stanowisko nr 5' => 5,
                'Stanowisko nr 6' => 6,
                'Stanowisko nr 7' => 7,
                'Stanowisko nr 8' => 8,
                'Stanowisko nr 9' => 9,
                'Stanowisko nr 10' => 10,
                'Stanowisko nr 11' => 11,
                'Stanowisko nr 12' => 12,
                'Stanowisko nr 13' => 13,
                'Stanowisko nr 14' => 14,
                'Stanowisko nr 15' => 15,
                'Stanowisko nr 16' => 16,
                'Stanowisko nr 17' => 17,
                'Stanowisko nr 18' => 18,
                'Stanowisko nr 19' => 19,
                'Stanowisko nr 20' => 20,

                
                ],'label'=>'Wybierz numer stanowiska:',
            ])
            ->add('since_when', DateTimeType::class,[
                //'widget' => 'text',
                'data'=>new \DateTime(),
                'label'=>'Zarezerwuj stanowisko od:',
                'minutes'=>range(0,30,30),
                'years'=>range(2022,2022,),
                'months'=>range(date('m'),12,),


                
            ])
            ->add('until_when', DateTimeType::class, [
                'label'=>'Zarezerwuj stanowisko do:',
                'data'=>new \DateTime(),
                'minutes'=>range(0,30,30),
                'years'=>range(2022,2022,),
                'months'=>range(date('m'),12,),

            ])
     
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FisheryReservations::class,
        ]);
    }
}
