<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('hours')
            ->add('color', null, array(
                'label' => 'Kolorea'
            ))
            ->add('orden')
            /**
             * Eremu honen bitartez esaten diogu orduak zehaztean egutegian
             * Zein eremutatik kendu behar dituen orduak
             **/
            ->add('related',ChoiceType::class, array(
                'label' => 'Erlazionatua',
                'placeholder' => 'Aukeratu bat',
                'choices' => array(
                    'Jai Egunak'          => 'hours_free'      ,
                    'Norberarentzakoak'   => 'hours_self'      ,
                    'Konpentsatuak'       => 'hours_compensed' ,
                    'Sindikalak'          => 'hours_sindical'
                )
            ))
            ->add('erakutsi',CheckboxType::class, array(
                'label'    => 'Erakutsi',
                'translation_domain' => 'messages',
            ))


        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Type'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_type';
    }


}
