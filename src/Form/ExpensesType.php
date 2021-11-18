<?php

namespace App\Form;

use App\Entity\Expenses;
use App\Entity\Tricount;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('users', EntityType::class, [
                "class" => Users::class,
                "choice_label" => "name",
                "multiple" => true
            ])
            ->add('Id_user', EntityType::class, [
                "class" => Users::class,
                "choice_label" => "name",
            ])
            ->add('Id_tricount', EntityType::class, [
                "class" => Tricount::class,
                "choice_label" => "id"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expenses::class,
        ]);
    }
}
