<?php

namespace AppBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uploadfile', VichFileType::class, [
            'required' => false,
            'allow_delete' => true, // optional, default is true
            'download_link' => true, // optional, default is true
            //'download_uri' => '...', // optional, if not provided - will automatically resolved using storage
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\File',
            'csrf_protection' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return 'file_type';
    }
}
