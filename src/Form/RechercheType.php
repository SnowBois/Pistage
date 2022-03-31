<?php

namespace App\Form;

use App\Entity\Recherche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Entity\Entreprise;
use App\Entity\Employe;
use App\Entity\MediaContact;
use App\Repository\EmployeRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\MediaContactRepository;
use App\Form\EntrepriseType;
use App\Form\EmployeType;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Validator\Constraints as Assert;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option): void
    {
        $builder
            ->add('mediaContact', EntityType::class, array(
                'class' => MediaContact::class,
                'choice_label' => 'intitule',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (MediaContactRepository $repositoryMediaContact) {
                    return $repositoryMediaContact->createQueryBuilder('mc')
                        ->orderBy('mc.intitule', 'ASC');
                },
                'placeholder' => "Sélectionner le média de contact...",
                'label' => 'Média de contact'
            ))
            ->add('observations', TextareaType::class, ['required' => false])
            ->add('entreprise', EntityType::class, array(
                'class' => Entreprise::class,
                'choice_label' => 'nom',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntrepriseRepository $repositoryEntreprise) {
                    return $repositoryEntreprise->createQueryBuilder('e')
                        ->orderBy('e.nom', 'ASC');
                },
                'placeholder' => "Choisissez l'entreprise..."
            ))
            ->add('nouvelleEntreprise', CollectionType::class, array(
                'entry_type' => EntrepriseType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'label' => false
            ))
            ->add('nouvelEmploye', CollectionType::class, array(
                'entry_type' => EmployeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'label' => false
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
                'constraints' => [
                    new Assert\NotBlank()
                ],
                'label_attr' =>  [
                    'class'=>'radio-inline' // Pour que les boutons radio soient alignés
                ],
                'mapped' => false, // Pour dire que cet attribut n'est pas dans l'entité (mais nous servira dans le contrôleur)
                'label' => "État de la recherche"
            ))
            // ->add('etatsRecherche')
            // ->add('etudiant')
            // ->add('stage')
        ;

        $formModifier = function (FormInterface $form, Entreprise $entreprise = null) {
            $employes = null === $entreprise ? array() : $entreprise->getEmployes();

            $form->add('employe', EntityType::class, array(
                'class' => Employe::class,
                'choice_label' => 'nomComplet',

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => false,
                'placeholder' => "Choisissez l'employé...",
                'choices' => $employes,
                'disabled' => $entreprise === null,
                'required' => false
            ));
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) 
            {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getEntreprise());
            }
        );

        $builder->get('entreprise')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) 
            {
                $entreprise = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $entreprise);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recherche::class,
        ]);
    }
}
