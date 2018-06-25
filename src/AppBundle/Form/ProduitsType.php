<?php

namespace AppBundle\Form;

use AppBundle\Entity\Fournisseurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('is_active')
            ->add('prix_achat')
            ->add('prix_vente')
            ->add('fournisseur', EntityType::class, array(
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
                'class' => Fournisseurs::class,
                'choice_attr' => function($fournisseur) use ($options){
                    $attr = array();
                    if(!empty($options['data']))
                    {
                        foreach ($options['data']->getProduitsFournisseurs() as $item){
                            if($fournisseur->getId() == $item->getFournisseurs()->getId()){
                                $attr['checked'] = 'checked';
                            }
                        }
                    }

                    return $attr;
                })
            )
            ->add('created_at')
            ->add('updated_at');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_produits';
    }


}
