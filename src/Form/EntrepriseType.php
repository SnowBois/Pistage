<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use App\Form\AdresseType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('numeroTelephone', TelType::class, array('label' => "Numéro de téléphone", 'required' => false))
            ->add('numeroFax', TelType::class, array('label' => "Numéro de fax", 'required' => false))
            ->add('adresseMail', EmailType::class, array('required' => false))
            ->add('typeEtablissement', TextType::class, array('label' => "Type d'établissement", 'required' => false))
            ->add('activite', TextAreaType::class, array('label' => "Activité", 'required' => false))
            ->add('numeroSIRET', TextType::class, array('label' => "Numéro de SIRET", 'required' => false))
            ->add('codeAPEouNAF', TextType::class, array('label' => "Code APE ou NAF", 'required' => false))
            ->add('statutJuridique')
            ->add('effectif', IntegerType::class, array('required' => false))
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
