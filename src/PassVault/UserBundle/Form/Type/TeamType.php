<?php

namespace PassVault\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class TeamType
 * @package PassVault\UserBundle\Form\Type
 */
class TeamType extends AbstractType
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

        $securityChecker = $this->container->get('security.authorization_checker');

        $builder->add('name', 'text', array(
            'label' => 'team.form.name.label',
        ));

        $builder->add('users', 'collection', array(
            'label' => 'team.form.name.label',
            'type' => 'teamuser',
            'allow_delete' => true,
            'options' => array(
                'required' => false
            )

        ));

        if ($securityChecker->isGranted('ROLE_ADMINISTRATOR', $options['data'])) {

            // Adding the submit button
            $builder->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'btn-sm btn-success'
                )
            ));

        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PassVault\UserBundle\Entity\Team',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'team';
    }
}