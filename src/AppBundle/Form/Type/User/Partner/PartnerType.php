<?php

namespace AppBundle\Form\Type\User\Partner;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use AppBundle\Form\Type\User\ProfileType;

class PartnerType extends ProfileType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('phoneMobile', PhoneNumberType::class, array(
                'label' => 'form.phone.mobile', 
                'default_region'    => 'FR',
                'format'    => PhoneNumberFormat::NATIONAL,
                'required'  => false
            ))
            ->add('phoneFixed', PhoneNumberType::class, array(
                'label' => 'form.phone.fixed', 
                'default_region'    => 'FR',
                'format'    => PhoneNumberFormat::NATIONAL,
                'required'  => false
            ))     
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Partner\Partner',
            'validation_groups' => 'Profile'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_partner';
    }


}
