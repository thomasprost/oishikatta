<?php
// src/AppBundle/Form/RecipeIngredientType.php
namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Ingredient;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('nameJa', null, array('label' => 'Japanese name'))
            ->add('imageFile', VichFileType::class, array(
                'attr' => array(
                    'class' => 'upload-image'
                ),
                'label' => 'Image',
                'required' => false
            ))
            ->add('parent', ChoiceType::class, array(
                'choices' => $options['ingredients'],
                'choice_label' => function($ing, $key, $index) {

                    return $key;
                },
                'choice_value' => function($index) {

                    return $index;
                }
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ingredient::class,
            'ingredients' => array()
        ));
    }
}