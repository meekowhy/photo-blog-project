<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PhotoType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageFile', VichFileType::class, array(
            'required' => false,
            'allow_delete' => true,
            'download_link' => true
        ))
        ->add('save',SubmitType::class,['label'=>'save photo']);
    }



}
