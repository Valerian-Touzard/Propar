<?php

namespace App\Form;

use App\Entity\Employee;
use Doctrine\Common\Collections\Expr\Value;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', NULL, [
                'label' => 'Compte'
            ])
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Expert' => 'ROLE_EXPERT',
                        'Senior' => 'ROLE_SENIOR',
                        'Apprenti' => 'ROLE_APPRENTICE',
                    ),
                    'label' => 'Rôle'
                )
            )
            ->add('password', PasswordType::class, [
                'data' => "",
                'label' => 'Mot de Passe'
            ])
            ->add('lastName', NULL, [
                'label' => 'Nom'
            ])
            ->add('firstName',NULL, [
                'label' => 'Prénom'
            ]);

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
