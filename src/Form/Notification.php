<?php

namespace App\Form;

use App\Entity\Expenses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpensesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):
    {
        $builder
            ->add('message',  [
                'readonly' => true,
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
