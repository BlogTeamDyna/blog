<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Tag;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;



class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class, [
                'attr' => [
                    'placeholder' => 'Rechercher via un mot clé..'
                ],
                'label' => false,
                'required' => false,
                'empty_data' => '',
            ]);
//            ->add('save', SubmitType::class, [
//                'label' => "rechercher"
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'data_class' => SearchData::class,
            'crf_protection' => false
           ]);
    }
}
