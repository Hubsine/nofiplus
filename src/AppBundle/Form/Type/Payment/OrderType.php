<?php

namespace AppBundle\Form\Type\Payment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Form\Type\AddressType;

abstract class OrderType extends ChoosePaymentMethodType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('address', AddressType::class, [
                'label' => 'form.order.address.billing'
            ]);
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefaults(array(
            'user'  => null
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_payment_order';
    }


}
