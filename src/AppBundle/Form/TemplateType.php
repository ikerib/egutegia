<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Izena', 'required'=>'required'))
            ->add('hours_year', null, array('label' => 'Lan orduak guztira', 'required' => true))
            ->add('hours_free', null, array('label' => 'Opor orduak guztira', 'required' => true))
            ->add('hours_self', null, array('label' => 'Norberarentzako orduak', 'required' => true))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Template'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_template';
    }


}
