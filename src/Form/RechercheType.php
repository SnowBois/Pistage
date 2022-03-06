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
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RechercheType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getRepositoryEmploye(): EmployeRepository
    {
        return $this->entityManager->getRepository(Employe::class);
    }

    public function buildForm(FormBuilderInterface $builder, array $option): void
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event)
            {
                $entreprise = $event->getData()->getEntreprise() ?? null;

                $repositoryEmploye = $this->getRepositoryEmploye();

                $employes = $entreprise === null ? [] : $repositoryEmploye->createQueryBuilder('em')
                                            ->andWhere('em.entreprise = :entreprise')
                                            ->setParameter('entreprise', $entreprise)
                                            ->orderBy('em.nom', 'ASC')
                                            ->getQuery()
                                            ->getResult();

                $event->getForm()->add('employe', EntityType::class, array(
                    'class' => Employe::class,
                    'choice_label' => 'nomComplet',

                    // used to render a select box, check boxes or radios
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => $employes,
                    'placeholder' => "Choisissez l'employé...",
                    'disabled' => $entreprise === null
                ));
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
