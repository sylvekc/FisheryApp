<?php

namespace App\Form;

use App\Entity\Photo;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\TextUI\XmlConfiguration\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class UploadPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filename', FileType::class, [
                'label'=>'Wybierz plik',
                'required'=>true,
                'constraints'=>[
                    new Constraints\File([
                        'maxSize'=>'2M',
                        'mimeTypes'=>[
                            'image/*'
                        ],
                        'mimeTypesMessage'=>'Plik musi być obrazem!'
                    ])
                ]

            ])
            ->add('weight',NumberType::class,[
                'label'=>'Waga ryby [kg]',
                'required'=>false,
                'attr'=>['min'=>0,'max'=>200]
            ])
            ->add('length',NumberType::class,[
                'label'=>'Długość [cm]',
                'required'=>false,
            ])
            ->add('type', ChoiceType::class,[
                'label'=>'Gatunek',
                'required'=>true,
                'choices'  => [
                    'Amur' => 'Amur',
                    'Jesiotr' => 'Jesiotr',
                    'Karaś' => 'Karaś',
                    'Karp' => 'Karp',
                    'Leszcz' => 'Leszcz',
                    'Lin' => 'Lin',
                    'Okoń' => 'Okoń',
                    'Płoć' => 'Płoć',
                    'Pstrąg' => 'Pstrąg',
                    'Sandacz' => 'Sandacz',
                    'Sum' => 'Sum',
                    'Szczupak' => 'Szczupak',
                    'Tołpyga' => 'Tołpyga',
                    'Węgorz' => 'Węgorz',
                    'Wzdręga' => 'Wzdręga',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
