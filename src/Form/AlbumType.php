<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Musique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Album', EntityType::class, [
                'class' => Musique::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('Id_Artiste', EntityType::class, [
                'class' => Artiste::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
