<?php

namespace App\Form;

use App\Entity\Recherche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Entreprise;
use App\Form\EmployeType;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mediaContact', ChoiceType::class, [
                'choices'  => [
                    'Courrier' => 'Courrier',
                    'Mail' => 'Mail',
                    'Présentiel' => 'Présentiel',
                    'Téléphone' => 'Téléphone'
                ],
                'placeholder' => 'Sélectionner...'
                ])
            ->add('observations', TextareaType::class, ['required' => false])
            ->add('employe', EmployeType::class)
            ->add('entreprise', EntityType::class, array(
                'class' => Entreprise::class,
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('etatsRecherche', ChoiceType::class, [
                'choices'  => [
                    'Refusé' => 'Refusé',
                    'En attente' => 'En attente',
                    'Relancé' => 'Relancé',
                    'Accepté' => 'Accepté'
                ],
                'multiple' => false,
                'expanded' => true,
                'label_attr' =>  [
                    'class'=>'radio-inline' //Pour que les boutons radio soient alignés
                  ]
                ])
            // ->add('etatsRecherche')
            // ->add('etudiant')
            // ->add('stage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
        ]);
    }
}
