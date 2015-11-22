<?php

namespace PassVault\PassBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class OrganizationType
 * @package PassVault\PassBundle\Form\Type
 */
class OrganizationType extends AbstractType
{

    protected $container;


    /**
     * __construct function.
     *
     * @access public
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', 'text', array(
            'label' => 'organization.form.name.label',
            'attr' => array(
                'class' => 'form-control')));

        // Adding the submit button
        $builder->add('submit', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-sm btn-success'
            )
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PassVault\PassBundle\Entity\Organization',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'organization';
    }
}