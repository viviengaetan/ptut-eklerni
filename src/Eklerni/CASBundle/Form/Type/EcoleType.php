<?php
/**
 * Created by PhpStorm.
 * User: Robert-U
 * Date: 20/03/14
 * Time: 10:33
 */

namespace Eklerni\CASBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EcoleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add(
            'nom', 'text', array(
                'label' => 'Nom'
            )
        );

        $builder->add(
            'codePostal', array(
                'label' => 'Code postal'
            )
        );

        $builder->add(
            'ville', 'text', array(
                'label' => 'Ville'
            )
        );

        $builder->add(
            'valider', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-default'
                )
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getName() {
        return 'ecole';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Eklerni\CASBundle\Entity\Ecole',
        ));
    }
}