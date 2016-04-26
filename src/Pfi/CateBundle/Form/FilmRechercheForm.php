<?php
/**
 * Created by JetBrains PhpStorm.
 * User: badane
 * Date: 22/03/15
 * Time: 01:28
 * To change this template use File | Settings | File Templates.
 */
namespace Pfi\CateBundle\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FilmRechercheForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('motcle', 'text', array('label' => 'Mot-clé'));
    }

    public function getName()
    {
        return 'filmrecherche';
    }
}