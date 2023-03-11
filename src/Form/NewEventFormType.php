<?php

namespace App\Form;

use App\Entity\Event;
use App\Enum\Severity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => '5'],
            ])
            ->add('severity', EnumType::class, [
                'class' => Severity::class,
                'expanded' => true,
                'row_attr' => ['class' => 'list-group',],
                'choice_label' => fn ($choice) => match ($choice) {
                    Severity::INFORMATIONAL => "Informational",
                    Severity::LOW => "Low",
                    Severity::MEDIUM => "Medium",
                    Severity::HIGH => "High",
                    Severity::CRITICAL => "Critical"
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
