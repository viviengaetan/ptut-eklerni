<?php
/**
 * Created by PhpStorm.
 * User: Robert-U
 * Date: 20/03/14
 * Time: 10:37
 */

namespace Eklerni\CASBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username', 'text', array(
                'label' => 'Nom d\'utilisateur'
            )
        );

        $builder->add(
            'password', 'text', array(
                'label' => 'Mot de passe'
            )
        );

        $builder->add(
            'nom', 'text', array(
                'label' => 'Nom'
            )
        );

        $builder->add(
            'prenom', 'text', array(
                'label' => 'Prénom'
            )
        );

        $builder->add(
            'dateNaissance', 'text', array(
                'label' => 'Date de Naissance'
            )
        );

        $builder->add('classe', 'entity', array(
                'label' => 'Classe',
                'class' => 'EklerniCASBundle:Classe',
                'property' => 'fullName'
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
    public function getName()
    {
        return 'eleve';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eklerni\CASBundle\Entity\Eleve',
        ));
    }
} 