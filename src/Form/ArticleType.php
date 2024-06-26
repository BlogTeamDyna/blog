<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "Titre"
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => "Description"
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'required' => false,
                'choice_label' => 'content',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'required' => false,
                'multiple' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                                 'maxSize' => '1024k',
                                 'mimeTypesMessage' => 'Veuillez choisir un format correct'
                             ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => "sauvegarder"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
