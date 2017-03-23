<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Izena',
                'required' => true
            ))
            ->add('template', EntityType::class, array(
                'required' => true,
                'class' => 'AppBundle\Entity\Template',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.created', 'DESC');
                },
                'choice_label' => function ($template) {
                    /** @var  $template \AppBundle\Entity\Template */
                    return $template->getName()."(".$template->getHoursYear().")";
                }
            ))
            //->add('template', TemplateType::class, array(
            //    'placeholder' => 'Choose a gender',
            //))

            ->add(
                'template',
                null,
                array(
                    'label' => 'Txantiloia',
                    'required' => true
                )
            )
            ->add('hoursYear',NumberType::class, array(
                'label_attr' => array('class'=>'col-sm-4'),
                'label' => 'Urteko lan orduak:',
                'required' => true
            ))
            ->add('hoursFree', NumberType::class, array(
                'label' => 'Opor orduak hartuta',
                'required' => true
            ))
            ->add('hoursSelf', NumberType::class, array(
                'label' => 'Norberarentzako orduak',
                'required' => true
            ))
            ->add('hoursCompensed', NumberType::class, array(
                'label' => 'Urterako ordu konpentsatuak',
                'required' => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Calendar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_calendar';
    }
}
