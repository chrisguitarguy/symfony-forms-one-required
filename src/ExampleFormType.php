<?php declare(strict_types=1);

namespace Chrisguitarguy\SymfonyFormOneRequired;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExampleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first', TextType::class, [
            'required' => false,
        ]);

        $builder->add('second', TextType::class, [
            'required' => false,
        ]);

        $builder->addEventSubscriber(new AtLeastOneRequiredListener('first', 'second'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('invalid_message', 'Either the first and/or second fields are required');
    }
}
