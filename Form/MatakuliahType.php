<?php

namespace Ais\MatakuliahBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MatakuliahType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kode')
            ->add('nama')
            ->add('nama_singkat')
            ->add('prodi_id')
            ->add('is_active')
            ->add('is_delete')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ais\MatakuliahBundle\Entity\Matakuliah',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
