<?php

namespace AppBundle\Form\Type\Payment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Form\Type\AddressType;
use AppBundle\Entity\Address;
use AppBundle\Entity\User\Abonne\Abonne;

abstract class OrderType extends \Symfony\Component\Form\AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('address', AddressType::class, [
                'label' => 'form.order.address.billing',
                'data_class'    => Address::class
            ]);
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setRequired('user');
        $resolver->setAllowedTypes('user', Abonne::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_payment_order';
    }


}
