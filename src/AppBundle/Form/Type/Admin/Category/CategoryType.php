<?php

namespace AppBundle\Form\Type\Admin\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

abstract class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'     => 'form.category.name.carte'
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'form.about',
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
            'data_class' => 'Symfony\Component\Form\Extension\Core\Type\FormType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return StringUtil::fqcnToBlockPrefix(get_class($this));
    }


}
