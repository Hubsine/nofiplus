<?php

namespace AppBundle\Form\Type\User\Partner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\User\Partner\CompanyLogoType;
use AppBundle\Form\Type\AddressType;
use AppBundle\Entity\Admin\Category\Company as CatCompany;

class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'form.company.name'
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'form.company.about'
            ))
            ->add('address', AddressType::class, array(
                'label' => 'form.company.address'
            ))
            ->add('logo', CompanyLogoType::class, array(
                'label' => 'form.company.logo',
                'by_reference'  => false
            ))
            ->add('category', EntityType::class, array(
                'label' => 'form.company.category',
                'class'  => CatCompany::class,
                'choice_label' => 'name',
                'multiple'  => false,
                'expanded'  => true
            ));
        
        if( isset($options['action']) && $options['action'] === 'update')
        { 
            $builder->get('logo')->setRequired(false);
        }
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Partner\Company',
            'validation_groups' => []
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_partner_company';
    }


}
