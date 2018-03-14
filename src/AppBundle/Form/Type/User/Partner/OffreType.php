<?php

namespace AppBundle\Form\Type\User\Partner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\User\Partner\FeaturedType;
use AppBundle\Entity\User\Partner\Offre;
use AppBundle\Entity\Admin\Category\Offre as CatOffre;

class OffreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.offre.name'
            ])
            ->add('about', TextareaType::class, [
                'label' => 'form.offre.about',
                'attr'  => ['class' => 'editable']
            ])
            ->add('howEnjoy', ChoiceType::class, [
                'label' => 'form.offre.how_enjoy',
                'choices'   => Offre::getHowEnjoys(),
                'multiple'  => true,
                'expanded'  => true,
                'label_attr'    => ['class' => 'form-check-inline checkbox-inline'],
                'choice_label' => function ($value, $key, $index) 
                {
                    return 'form.how_enjoy.' . $value;
                },
                'choice_attr' => function($val, $key, $index) 
                {
                    $class = $val === 'all' ? 'all' : 'checkboxItem ' . $val;
                    return ['class' => $class];
                },
            ])
            ->add('enjoyByLocation', TextareaType::class, [
                'label' => 'form.offre.by_location',
                'attr'  => ['class' => 'editable location enjoyByTextarea']
            ])
            ->add('enjoyByWeb', TextareaType::class, [
                'label' => 'form.offre.by_web',
                'attr'  => ['class' => 'editable web enjoyByTextarea']
            ])
            ->add('enjoyByTel', TextareaType::class, [
                'label' => 'form.offre.by_tel',
                'attr'  => ['class' => 'editable tel enjoyByTextarea']
            ])
            ->add('start', DateType::class, [
                'label' => 'form.offre.start',
                'attr'  => ['class' => 'datepicker start'],
                'widget'    => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy'
            ])
            ->add('end', DateType::class, [
                'label' => 'form.offre.end',
                'attr'  => ['class' => 'datepicker end'],
                'widget'    => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy'
            ])
            ->add('category', EntityType::class, [
                'label' => 'form.offre.category',
                'class' => CatOffre::class,
                'choice_label'  => 'name',
                'label_attr'    => ['class' => 'form-check-inline radio-inline'],
                'multiple'  => false,
                'expanded'  => true
            ])
            ->add('featured', FeaturedType::class, [
                'label' => 'form.offre.featured',
                'by_reference'  => false
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\Partner\Offre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_partner_offre';
    }


}
