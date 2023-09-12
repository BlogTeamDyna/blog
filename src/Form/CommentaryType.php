<?php

namespace App\Form;


use App\Entity\Commentary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;


class CommentaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Laissez un commentaire si cet article vous a plu !'
                ],
                'required' => true,
                'label' => false,
                ])
            ->add('save', SubmitType::class, [
                'label' => "commenter"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Commentary::class,
        ]);
    }
}
