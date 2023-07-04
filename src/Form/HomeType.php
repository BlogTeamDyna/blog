<?php


namespace App\Form;

use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'required' => true,
                'choice_label' => 'content',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => "Filtrer"
            ]);

    }
//Tag::class
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                                   'data_class' => null ,
                               ]);
    }
}


