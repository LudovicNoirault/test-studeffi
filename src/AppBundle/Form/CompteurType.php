<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CompteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('numeroVoie', IntegerType::class)
            ->add('nomVoie', TextType::class)
            ->add('codePostal', IntegerType::class)
            ->add('ville', TextType::class)
            ->add('codeInsee', HiddenType::class)
            ->add('enregistrer', SubmitType::class, [
                'disabled' => 'true',
            ]);
    }
}