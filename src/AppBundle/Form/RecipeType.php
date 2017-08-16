<?php
// src/AppBundle/Form/RecipeType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Recipe;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('intro')
            ->add('mainImageFile', VichFileType::class, array(
                'attr' => array(
                    'class' => 'upload-image'
                ),
                'required' => false
            ) )
            ->add('numberPeople')
            ->add('minutes')
            ->add('link')
            ->add('countries')
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