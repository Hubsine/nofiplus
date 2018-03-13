<?php

namespace AppBundle\Form\Type\User\Partner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\User\Partner\FeaturedType;
use AppBundle\Entity\Admin\Category\Offre;

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
            ->add('howEnjoy', RadioType::class, [
                'label' => 'form.offre.how_enjoy'
            ])
            ->add('enjoyByLocation', TextareaType::class, [
                'label' => 'form.offre.by_location',
                'attr'  => ['class' => 'editable']
            ])
            ->add('enjoyByWeb', TextareaType::class, [
                'label' => 'form.offre.by_web',
                'attr'  => ['class' => 'editable']
            ])
            ->add('enjoyByTel', TextareaType::class, [
                'label' => 'form.offre.by_tel',
                'attr'  => ['class' => 'editable']
            ])
            ->add('start', DateTimeType::class, [
                'label' => 'form.offre.start',
                'attr'  => ['class' => 'datepicker']
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'form.offre.end',
                'attr'  => ['class' => 'datepicker']
            ])
            ->add('category', EntityType::class, [
                'label' => 'form.offre.category',
                'class' => Offre::class,
                'choice_label'  => 'name',
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
