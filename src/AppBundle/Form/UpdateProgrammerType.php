<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13.10.2017
 * Time: 12:46
 */

namespace AppBundle\Form;


use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProgrammerType extends ProgrammerType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(['is_edit' => true]);
    }

}