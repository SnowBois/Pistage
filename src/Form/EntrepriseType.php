<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\AdresseType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('numeroTelephone')
            ->add('typeEtablissement')
            ->add('activite')
            ->add('numeroSIRET')
            ->add('codeAPEouNAF')
            ->add('statutJuridique')
            ->add('effectif')
            ->add('numeroFax')
            ->add('adresseMail')
            ->add('siteWeb')
            ->add('adresse', AdresseType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
