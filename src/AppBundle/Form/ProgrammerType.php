<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12.10.2017
 * Time: 15:03
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['disabled' => $options['is_edit']])
            ->add('subFamily', TextType::class)
            ->add('speciesCount', IntegerType::class)
            ->add('funFact', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Genus',
            'is_edit' => false,
        ));
    }

}