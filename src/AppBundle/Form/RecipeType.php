<?php
// src/AppBundle/Form/RecipeType.php
namespace AppBundle\Form;

use AppBundle\Entity\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Recipe;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'label' => 'Image',
                'required' => false
            ) )
            ->add('numberPeople',IntegerType::class , array(
                'label' => 'For how many people ?'
            ))
            ->add('minutes',IntegerType::class , array(
                'label' => 'Time it takes (in Minutes)'
            ))
            ->add('link')
            ->add('country')
            ->add('recipeSteps', CollectionType::class, array(
                // each entry in the array will be an "recipeStep" field
                'entry_type'   => RecipeStepType::class,
                'allow_add' => true,
                'allow_delete' => true,
                // these options are passed to each "recipeStep" type
                'entry_options'  => array(
                    'attr'      => array('class' => 'step-box')
                )
            ))
            ->add('recipeIngredients', CollectionType::class, array(
                // each entry in the array will be an "recipeIngredient" field
                'entry_type'   => RecipeIngredientType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                // these options are passed to each "recipeIngredient" type
                'entry_options'  => array(
                    'attr'      => array('class' => 'ingredient-box')
                )
            ))
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