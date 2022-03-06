<?php

namespace App\Form;

use App\Entity\Recherche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Entity\Entreprise;
use App\Entity\Employe;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mediaContact', ChoiceType::class, array(
                'choices'  => [
                    'Courrier' => 'Courrier',
                    'Mail' => 'Mail',
                    'Présentiel' => 'Présentiel',
                    'Téléphone' => 'Téléphone'
                ],
                'placeholder' => "Sélectionner le média de contact..."
            ))
            ->add('observations', TextareaType::class, ['required' => false])
            ->add('entreprise', EntityType::class, array(
                'class' => Entreprise::class,
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nom', 'ASC');
                },
                'placeholder' => "Choisissez l'entreprise..."
            ))
            ->add('employe', EntityType::class, array(
                'class' => Employe::class,
                'choice_label' => 'nomCompletEtEntreprise',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('em')
                        ->select('em, en')
                        ->join('em.entreprise', 'en')
                        ->orderBy('en.nom', 'ASC');
                },
                'placeholder' => "Choisissez l'employé...",
                'disabled' => true
            ))
            ->add('premierEtat', ChoiceType::class, array(
                'choices'  => [
                    'Refusé' => 'Refusé',
                    'En attente' => 'En attente',
                    'Relancé' => 'Relancé',
                    'Accepté' => 'Accepté'
                ],
                'multiple' => false,
                'expanded' => true,
                'label_attr' =>  [
                    'class'=>'radio-inline' // Pour que les boutons radio soient alignés
                ],
                'mapped' => false // Pour dire que cet attribut n'est pas dans l'entité (mais nous servira dans le contrôleur)
            ))
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
