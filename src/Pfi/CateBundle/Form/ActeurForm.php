<?php

namespace Pfi\CateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class ActeurForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('dateNaissance', 'birthday');
        $builder->add('sexe', 'choice', array('choices' => array('F'=>'Féminin','M'=>'Masculin')));

    }

    public function getName()
    {
        return 'acteur';
    }

}