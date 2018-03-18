<?php

namespace AppBundle\Form\Type\Payment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use JMS\Payment\CoreBundle\PluginController\PluginControllerInterface;
use AppBundle\Form\Type\Payment\OrderType;
use AppBundle\Form\Type\User\Abonne\AbonneOrderType;
use AppBundle\Entity\User\Abonne\Abonne;
use AppBundle\Entity\Address;

class OrderCarteType extends OrderType
{
    public function __construct(PluginControllerInterface $pluginController, array $paymentMethods) {
        parent::__construct($pluginController, $paymentMethods);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('user', AbonneOrderType::class, [
                'label' => 'form.infos'
            ]);
        
        if( $options['user'] instanceof Abonne && $options['user']->getAddress() instanceof Address )
        {
            $builder
                ->add('shipping_as_billing_address', CheckboxType::class, [
                    'label' => 'form.order.address.shipping_as_billing_address',
                    'mapped'    => false,
                    'data'  => true,
                    'required'  => false
                ]);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Payment\OrderCarte',
            'validation_groups' => ['Order']
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
