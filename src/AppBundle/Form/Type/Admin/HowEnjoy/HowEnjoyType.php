<?php

namespace AppBundle\Form\Type\Admin\HowEnjoy;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Admin\HowEnjoy\AbstractHowEnjoy;

class HowEnjoyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enjoyBy', ChoiceType::class, array(
                'label' => 'form.how_enjoy.by',
                'label_attr'    => array('class'    => 'h6'),
                'choices'   => AbstractHowEnjoy::getEnjoyBys(),
                'choice_translation_domain' => true,
                'choice_label' => function ($value, $key, $index) {
                    return 'form.how_enjoy.'.$value;
                },
                'expanded'  => true, 
                'multiple'  => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\HowEnjoy\HowEnjoy'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_admin_howenjoy';
    }
}
