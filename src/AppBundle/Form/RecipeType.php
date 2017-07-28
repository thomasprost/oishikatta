<?php
// src/AppBundle/Form/RecipeType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Recipe;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('intro')
            ->add('mainImage')
            ->add('numberPeople')
            ->add('minutes')
            ->add('link')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recipe::class,
        ));
    }
}