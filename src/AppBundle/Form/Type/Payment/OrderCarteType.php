<?php

namespace AppBundle\Form\Type\Payment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use JMS\Payment\CoreBundle\PluginController\PluginControllerInterface;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use AppBundle\Form\Type\Payment\OrderType;
use AppBundle\Form\Type\User\Abonne\AbonneOrderType;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\Address;
use AppBundle\Entity\Payment\OrderCarte;

class OrderCarteType extends OrderType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('user', AbonneOrderType::class, [
                'label' => 'form.infos',
                'data_class'    => Abonne::class
            ]);
        
        $builder
            ->add('shipping_as_billing_address', CheckboxType::class, [
                'label' => 'form.order.address.shipping_as_billing_address',
                'mapped'    => false,
                'data'  => true,
                'required'  => false
            ]);
            
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) 
            {
                $form = $event->getForm();
                $orderCarte = $event->getData();
                
                $shippingAddress = $orderCarte['user']['address'];
                
                if( isset( $orderCarte['shipping_as_billing_address'] ) )
                {
                    // Shipping address in billing address
                    $orderCarte['address'] = $shippingAddress;
                    
                    $event->setData($orderCarte);
                }
                
                
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Payment\OrderCarte',
            'allow_extra_fields'=>true,
            #'validation_groups' => ['Order']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_payment_ordercarte';
    }


}
