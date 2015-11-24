<?php

namespace PassVault\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class TeamUserType
 * @package PassVault\UserBundle\Form\Type
 */
class TeamUserType extends AbstractType
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

        $builder->add('team', 'entity_hidden', array(
            'class' => 'PassVault\UserBundle\Entity\Team'
        ));

        $builder->add('user', 'entity_hidden', array(
            'class' => 'PassVault\UserBundle\Entity\User'
        ));

        $builder->add('role', 'choice', array(
            'label' => 'teamuser.form.user.label',
            'choices' => array(
                'ROLE_ADMIN' => 'teamuser.form.role.list.admin',
                'ROLE_CONTRIBUTOR' => 'teamuser.form.role.list.contributor',
                'ROLE_READER' => 'teamuser.form.role.list.reader'
            ),
            'attr' => array(
                'style' => 'display: none;'
            )
        ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PassVault\UserBundle\Entity\TeamUser',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'teamuser';
    }
}