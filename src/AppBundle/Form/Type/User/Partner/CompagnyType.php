<?php

namespace AppBundle\Form\Type\User\Partner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\User\Partner\CompagnyLogoType;
use AppBundle\Form\Type\AddressType;
use AppBundle\Entity\Admin\Category\Compagny as CatCompagny;

class CompagnyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'form.compagny.name'
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'form.compagny.about'
            ))
            ->add('address', AddressType::class, array(
                'label' => 'form.compagny.address'
            ))
            ->add('logo', CompagnyLogoType::class, array(
                'label' => 'form.compagny.logo'
            ))
            ->add('category', EntityType::class, array(
                'label' => 'form.compagny.category',
                'class'  => CatCompagny::class,
                'choice_label' => 'name',
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Partner\Compagny'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_partner_compagny';
    }


}
