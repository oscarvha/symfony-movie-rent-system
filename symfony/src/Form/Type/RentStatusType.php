<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Form\Type;


use App\Entity\ValueObject\RentStatus;
use App\Service\DTO\RentChangeStatusDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentStatusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('newStatus', ChoiceType::class, [
           'label' => false,
           'choices' => [
               'rent.cancel' => RentStatus::CANCELED,
               'rent.confirm_wait_send' => RentStatus::CONFIRM_WAIT_SEND,
               'rent.confirm_and_send' => RentStatus::CONFIRM_AND_SEND,
               'rent.delivered' => RentStatus::DELIVERED,
               'rent.return_user' => RentStatus::RETURNED_USER,
               'rent.finish' => RentStatus::FINISH,
           ],
       ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RentChangeStatusDTO::class]);
    }
}