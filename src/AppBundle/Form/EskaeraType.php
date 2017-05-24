<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EskaeraType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('type', EntityType::class, [
                    'label' => 'Mota',
                    'required' => true,
                    'expanded' => true,
                    'class' => 'AppBundle\Entity\Type',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.erakutsi_eskaera=true')
                            ->orderBy('u.created', 'DESC');
                    },
                    'choice_label' => function ($template) {
                        /* @var  $template \AppBundle\Entity\Template */
                        return $template->getName();
                    }, ]
            )
            ->add('hasi', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker', 'data-provide' => 'datepicker'],
            ])
            ->add('amaitu', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker', 'data-provide' => 'datepicker'],
            ])
            ->add('orduak')
            ->add('noiz', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker', 'data-provide' => 'datepicker'],
            ])


            ->add('user')
            ->add('calendar')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Eskaera'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_eskaera';
    }


}
