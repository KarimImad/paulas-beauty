<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Service;
use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom'])
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('phone', TextType::class, ['label' => 'Téléphone'])
            ->add('scheduleAt', DateTimeType::class, [
                'label' => 'Date du créneau',
                'widget' => 'single_text',
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'label' => 'Service',
            ])
            ->add('schedule', EntityType::class, [
                'class' => Schedule::class,
                'choice_label' => function(Schedule $s) {
                    return $s->getStartHour()->format('d/m/Y H:i') . ' - ' . $s->getService()->getName();
                },
                'label' => 'Créneau',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
