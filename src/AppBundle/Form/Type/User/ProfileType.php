<?php

namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Type\AddressType;
use AppBundle\Entity\User\UserTrait;

abstract class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birthday', BirthdayType::class, array(
                'label' => 'form.birthday',
                'label_attr'    => array('class'    => 'h6'),
                'placeholder'   => array('year' => 'form.choose.year', 'month' => 'form.choose.month', 'day' => 'form.choose.day'),
                'view_timezone' => 'Europe/Paris',
                'format'    => 'dd-MM-yyyy'
            ))
            ->add('username', TextType::class, array(
                'label' => 'form.username'
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'form.first_name'
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'form.last_name'
            ))    
            ->add('gender', ChoiceType::class, array(
                'label' => 'form.gender.label',
                'label_attr'    => array('class'    => 'h6'),
                'choices'   => UserTrait::getGenders(),
                'choice_translation_domain' => true,
                'choice_label' => function ($value, $key, $index) {
                    return 'form.gender.'.$value;
                },
                'expanded'  => true, 
                'multiple'  => false
            ))
            ->add('address', AddressType::class, array(
                'label' => 'form.address',
                'label_attr'    => array('class'    => 'h6')
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
            'validation_groups' => ['Profile']
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
