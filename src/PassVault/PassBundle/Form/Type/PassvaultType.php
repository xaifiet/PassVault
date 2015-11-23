<?php

namespace PassVault\PassBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class PassvaultType
 * @package PassVault\PassBundle\Form\Type
 */
class PassvaultType extends AbstractType
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
            'label' => 'node.form.name.label',
        ));

        $builder->add('parent', 'entity_modal', array(
            'label' => 'node.form.parent.label',
            'entity_label' => array('name'),
            'entity_repository' => 'PassVaultPassBundle:Node',
            'entity_classes' => array(
                'PassVault\PassBundle\Entity\Organization',
                'PassVault\PassBundle\Entity\Folder',
            ),
            'entity_parent' => 'parent',
            'entity_sort' => array('name')
        ));

        $builder->add('link', 'text', array(
            'label' => 'passvault.form.link.label',
        ));

        $builder->add('account', 'text', array(
            'label' => 'passvault.form.account.label',
        ));

        $builder->add('password', 'text', array(
            'label' => 'passvault.form.password.label',
        ));

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
            'data_class' => 'PassVault\PassBundle\Entity\Password',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'passvault';
    }
}