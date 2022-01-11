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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add(
                'status',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'En Attente' => 'pending',
                        'En Cours' => 'in_progress',
                        'Terminée' => 'done',
                        'Annulée' => 'cancelled'
                    ),
                    'label' => 'État',
                )
                
            )
            ->add(
                'type',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Petite (1 000€)' => 'small',
                        'Moyenne (2 500€)' => 'medium',
                        'Grosse (10 000€)' => 'big'
                    ),
                    'label' => 'Type',
                )
            )
            ->add('userId', EntityType::class, [
                'class' => Employee::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("JSON_EXTRACT( u.roles, '$[0]') != '' ")
                        ->orderBy('u.firstName', 'ASC');
                },
                'choice_label' => 'firstName',
                'label' => 'Employé',
            ])
            ->add('clientId', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("LENGTH(u.firstName) <= 30 and LENGTH(u.lastName) <= 30")
                        ->orderBy('u.firstName', 'ASC');
                },
                'choice_label' => 'firstName',
                'label' => 'Client',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
