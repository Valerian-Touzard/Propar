<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'attr' => array('maxlength' => '30'),
                'label' => 'Prénom',
            ])
            ->add('lastName', null, [
                'attr' => array('maxlength' => '30'),
                'label' => 'Nom',
            ])
            ->add('address', null, [
                'attr' => array(
                    'list' => 'addressList',
                    'autocomplete' => 'off',
                    'maxlength' => '250'
                ),
                'label' => 'Adresse',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
