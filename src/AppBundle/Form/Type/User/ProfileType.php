<?php

namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use libphonenumber\PhoneNumberFormat;
use AppBundle\Form\Type\User\AvatarType;
use AppBundle\Form\Type\AddressType;
use AppBundle\Entity\User\SocialNetwork;
use AppBundle\Entity\User\User;
use AppBundle\Entity\Admin\SoccerPost;
use Symfony\Component\Form\FormBuilder;

class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', AvatarType::class, array(
                'required'  => false
            ))
            ->add('birthday', BirthdayType::class, array(
                'label' => 'form.birthday',
                'label_attr'    => array('class'    => 'h6'),
                'placeholder'   => array('year' => 'form.choose.year', 'month' => 'form.choose.month', 'day' => 'form.choose.day'),
                'view_timezone' => 'Europe/Paris',
                'format'    => 'dd-MM-yyyy',
                'required'  => false,
            ))
            ->add('username', TextType::class, array(
                'label' => 'form.username',
                'required'  => false
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'form.first_name',
                'required'  => false
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'form.last_name',
                'required'  => false
            ))    
            ->add('gender', ChoiceType::class, array(
                'label' => 'form.gender.label',
                'label_attr'    => array('class'    => 'h6'),
                'choices'   => User::getGenders(),
                'choice_translation_domain' => true,
                'choice_label' => function ($value, $key, $index) {
                    return 'form.gender.'.$value;
                },
                'expanded'  => true, 
                'multiple'  => false
            ))
            ->add('phone', PhoneNumberType::class, array(
                'label' => 'form.phone', 
                'default_region'    => 'FR',
                'format'    => PhoneNumberFormat::NATIONAL,
                'required'  => false
            ))
            ->add('address', AddressType::class, array(
                'label' => 'form.address',
                'label_attr'    => array('class'    => 'h6'),
                'required'  => false
            ))
            ->add('quote', TextType::class, array(
                'label' => 'form.quote',
                'required'  => false
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'form.about',
                'required'  => false
            ))
            ->add('soccerPost', EntityType::class, array(
                'label' => 'form.soccer_post',
                'label_attr'    => array('class'    => 'h6'),
                'class'   => 'AppBundle:Admin\SoccerPost',
                'choice_label' => 'post',
                'choice_translation_domain' => false,
                'multiple'  => false,
                'expanded'  => true,
                'required'  => false
            ))
            ->add('socialNetworks', CollectionType::class, array(
                'label' => 'form.social_networks',
                'entry_type' => SocialNetworkType::class,
                'allow_add' => true,
                'allow_delete'  => true,
                'prototype' => true,
                'by_reference'  => false,
                'entry_options' => [
                   'label' => 'Réseau social',
                ],
                'attr'  => [
                    'class' => 'sfCollection',
                    'data-name-prefix'  => 'user_social_network'
                ]
            ))  
            ;
                
            $birthdayField      = $builder->get('birthday');
            $dayFieldOptions    = $birthdayField->get('day')->getOptions();
            $monthFieldOptions  = $birthdayField->get('month')->getOptions();
            $yearFieldOptions   = $birthdayField->get('year')->getOptions();
            
            $dayFieldOptions['attr'] = ['class'    => 'col'];
            $monthFieldOptions['attr'] = ['class'    => 'col'];
            $yearFieldOptions['attr'] = ['class'    => 'col'];
            
            $birthdayField->add('day', ChoiceType::class, $dayFieldOptions);
            $birthdayField->add('month', ChoiceType::class, $monthFieldOptions);
            $birthdayField->add('year', ChoiceType::class, $yearFieldOptions);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\User',
            'validation_groups' => 'Profile'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_user';
    }


}
