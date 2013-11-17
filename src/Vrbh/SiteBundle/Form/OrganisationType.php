<?php

namespace Vrbh\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrganisationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('created')
            //->add('updated')
            //->add('creator')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Vrbh\SiteBundle\Entity\Organisation',
            'csrf_protection'   => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vrbh_sitebundle_organisation';
    }
}
