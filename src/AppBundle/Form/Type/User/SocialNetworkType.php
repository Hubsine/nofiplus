<?php

namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Admin\SocialNetworkAvaible;

class SocialNetworkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('socialNetworkAvaible', EntityType::class, array(
                'label' => 'form.social_networks',
                'class' => SocialNetworkAvaible::class,
                'choice_label'  => 'name'
            ))
            ->add('url', UrlType::class, array(
                'label' => 'form.url',
                'default_protocol'  => 'https', 
                'attr' => ['placeholder'   => 'https://']
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\SocialNetwork'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_socialnetwork';
    }
}
