<?php

namespace PassVault\PassBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class NodeType
 * @package PassVault\PassBundle\Form\Type
 */
class NodeType extends AbstractType
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

        $builder->add('teams', 'collection', array(
            'label' => 'team.form.teams.label',
            'type' => 'nodeteam',
            'allow_delete' => true,
            'options' => array(
                'required' => false
            )
        ));

        $builder->add('users', 'collection', array(
            'label' => 'team.form.users.label',
            'type' => 'nodeuser',
            'allow_delete' => true,
            'options' => array(
                'required' => false
            )
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PassVault\PassBundle\Entity\Node',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'node';
    }
}