<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Client;
use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('status')
            ->add('type')
            ->add('userId', EntityType::class, [
                'class' => Employee::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstName', 'ASC');
                },
                'choice_label' => 'firstName',
            ])
            ->add('clientId', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstName', 'ASC');
                },
                'choice_label' => 'firstName',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
