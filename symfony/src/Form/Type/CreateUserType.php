<?php

namespace App\Form\Type;

use App\Entity\ValueObject\Roles;
use App\Service\DTO\UserCreateDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
            ])
            ->add('plainPassword', PasswordType::class, [
                'empty_data' => '',
            ]);
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCreateDTO::class,
            'empty_data' => function (FormInterface $form) {
                return new UserCreateDTO(
                    $form->get('username')->getData() ?: '',
                    $form->get('email')->getData() ?: '',
                    $form->get('plainPassword')->getData() ? : ''
                );
            },
        ]);
    }


}