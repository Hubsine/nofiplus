<?php

namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\User\RegistrationType;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\Partner\Partner;
use Misd\PhoneNumberBundle\Templating\Helper\PhoneNumberHelper;

class RegistrationPartnerType extends RegistrationType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('gender', ChoiceType::class, array(
                'label' => 'form.gender.label',
                'attr'  => ['class' => 'form-check form-check-inline' ],
                'label_attr'    => array('class'    => 'h6'),
                'choices'   => Partner::getGenders(),
                'choice_translation_domain' => true,
                'choice_label' => function ($value, $key, $index) {
                    return 'form.gender.'.$value;
                },
                'expanded'  => true, 
                'multiple'  => false
            ))    
            ->add('firstName', TextType::class, array(
                'label' => 'form.first_name',
                'required'  => false
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'form.last_name',
                'required'  => false
            ))                
            ->add('phoneMobile', PhoneNumberType::class, array(
                'label' => 'form.phone.mobile', 
                'default_region'    => 'FR',
                #'format'    => PhoneNumberFormat::NATIONAL,
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
            'data_class' => Partner::class,
            'csrf_token_id' => 'registration',
            'translation_domain'    => 'messages',
            'validation_group' => ['partner', 'Registration']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fos_user_registration_partner';
    }
}
