<?php
/**
 * User: Oscar Sanchez
 * Date: 2/4/21
 */

namespace App\Form\Type;


use App\Service\DTO\MovieCreateDTO;
use App\Service\DTO\UserCreateDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateMovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'movie.form.title',
                'empty_data' => '',

            ])->add('reference', TextType::class, [
                'label' => 'movie.form.reference',
                'required' => true
            ])->add('stock', IntegerType::class, [
                'label' => 'movie.form.stock',
                'required' => true
            ])->add('image', FileType::class, [
                'label' => 'movie.form.image',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MovieCreateDTO::class]);
    }
}