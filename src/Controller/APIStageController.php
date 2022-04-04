<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\StageRepository;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/stage")
 */
class APIStageController extends AbstractController
{
    const TABLEAU_ATTRIBUTS_STAGE = ["id", "affiliationSecuriteSociale", "caisseAssuranceMaladie", "nombrePersonnesAidant", "moyensOutilsDisponibles", "autreMateriel", "typeTaches", "autresTaches", "competences", "confidentiel", "sujet", "interrompu", "dateDebut", "dateFin", "dureeEnHeures", "nombreJoursTravailHebdomadaires", "nombreJoursConges", "gratifie", "tauxHoraireNetParHeure", "montantGratification", "deviseLocale", "modalitesVersement", "modaliteSuiviStagiaire", "listeAvantagesEnNature", "natureTravailFourniSuiteAuStage", "presencesExceptionnelles", "typeStage", "thematiqueStage", "informationsComplementaires", "modaliteValidationStage", "nombreHeuresEnseignement"];

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}&{nomParam5}={valeurParam5}", name="api_stage_5_param")
     */
    public function requete5param(StageRepository $repositoryStage, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3,
                                    $nomParam4, $valeurParam4,
                                    $nomParam5, $valeurParam5): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);
        $nomParam4 = $this->enleverAccents($nomParam4);
        $nomParam5 = $this->enleverAccents($nomParam5);

        if($this->in_arrayi($nomParam1, APIStageController::TABLEAU_ATTRIBUTS_STAGE) 
        && $this->in_arrayi($nomParam2, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam3, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam4, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam5, APIStageController::TABLEAU_ATTRIBUTS_STAGE))
        {
            $resultat = $repositoryStage->findBy(array(
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam1,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam1, 
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam2,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam2,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam3,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam3,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam4,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam4,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam5,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam5));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['stage', 'recherche', 'mediacontact', 'etatrecherche', 'employe_sans_entreprise', 'entreprise', 'adresse', 'etudiant', 'cursus_sans_etudiants', 'etablissementenseignement_sans_stages', 'enseignantreferent_sans_stages']]);

                return JsonResponse::fromJsonString($jsonContent);
            }
            else
            {
                return new JsonResponse([
                    'error' => "La requête n'a renvoyé aucun résultat."
                ], 401);
            }
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre(s) invalide(s).'
            ], 401);
        }
    }

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}", name="api_stage_4_param")
     */
    public function requete4param(StageRepository $repositoryStage, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3,
                                    $nomParam4, $valeurParam4): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);
        $nomParam4 = $this->enleverAccents($nomParam4);

        if($this->in_arrayi($nomParam1, APIStageController::TABLEAU_ATTRIBUTS_STAGE) 
        && $this->in_arrayi($nomParam2, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam3, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam4, APIStageController::TABLEAU_ATTRIBUTS_STAGE))
        {
            $resultat = $repositoryStage->findBy(array(
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam1,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam1, 
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam2,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam2,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam3,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam3,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam4,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam4));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['stage', 'recherche', 'mediacontact', 'etatrecherche', 'employe_sans_entreprise', 'entreprise', 'adresse', 'etudiant', 'cursus_sans_etudiants', 'etablissementenseignement_sans_stages', 'enseignantreferent_sans_stages']]);

                return JsonResponse::fromJsonString($jsonContent);
            }
            else
            {
                return new JsonResponse([
                    'error' => "La requête n'a renvoyé aucun résultat."
                ], 401);
            }
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre(s) invalide(s).'
            ], 401);
        }
    }

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}", name="api_stage_3_param")
     */
    public function requete3param(StageRepository $repositoryStage, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);

        if($this->in_arrayi($nomParam1, APIStageController::TABLEAU_ATTRIBUTS_STAGE) 
        && $this->in_arrayi($nomParam2, APIStageController::TABLEAU_ATTRIBUTS_STAGE)
        && $this->in_arrayi($nomParam3, APIStageController::TABLEAU_ATTRIBUTS_STAGE))
        {
            $resultat = $repositoryStage->findBy(array(
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam1,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam1, 
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam2,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam2,
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam3,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam3));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['stage', 'recherche', 'mediacontact', 'etatrecherche', 'employe_sans_entreprise', 'entreprise', 'adresse', 'etudiant', 'cursus_sans_etudiants', 'etablissementenseignement_sans_stages', 'enseignantreferent_sans_stages']]);

                return JsonResponse::fromJsonString($jsonContent);
            }
            else
            {
                return new JsonResponse([
                    'error' => "La requête n'a renvoyé aucun résultat."
                ], 401);
            }
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre(s) invalide(s).'
            ], 401);
        }
    }

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}", name="api_stage_2_param")
     */
    public function requete2param(StageRepository $repositoryStage, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);

        if($this->in_arrayi($nomParam1, APIStageController::TABLEAU_ATTRIBUTS_STAGE) 
        && $this->in_arrayi($nomParam2, APIStageController::TABLEAU_ATTRIBUTS_STAGE))
        {
            $resultat = $repositoryStage->findBy(array(
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam1,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam1, 
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam2,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam2));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['stage', 'recherche', 'mediacontact', 'etatrecherche', 'employe_sans_entreprise', 'entreprise', 'adresse', 'etudiant', 'cursus_sans_etudiants', 'etablissementenseignement_sans_stages', 'enseignantreferent_sans_stages']]);

                return JsonResponse::fromJsonString($jsonContent);
            }
            else
            {
                return new JsonResponse([
                    'error' => "La requête n'a renvoyé aucun résultat."
                ], 401);
            }
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre(s) invalide(s).'
            ], 401);
        }
    }

    /**
     * @Route("/{nomParam1}={valeurParam1}", name="api_stage_1_param")
     */
    public function requete1param(StageRepository $repositoryStage, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);

        if($this->in_arrayi($nomParam1, APIStageController::TABLEAU_ATTRIBUTS_STAGE))
        {
            $resultat = $repositoryStage->findBy(array(
            APIStageController::TABLEAU_ATTRIBUTS_STAGE[$this->array_searchi($nomParam1,APIStageController::TABLEAU_ATTRIBUTS_STAGE)] => $valeurParam1));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['stage', 'recherche', 'mediacontact', 'etatrecherche', 'employe_sans_entreprise', 'entreprise', 'adresse', 'etudiant', 'cursus_sans_etudiants', 'etablissementenseignement_sans_stages', 'enseignantreferent_sans_stages']]);

                return JsonResponse::fromJsonString($jsonContent);
            }
            else
            {
                return new JsonResponse([
                    'error' => "La requête n'a renvoyé aucun résultat."
                ], 401);
            }
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre(s) invalide(s).'
            ], 401);
        }
    }

    function array_searchi($needle, $haystack) {
        return array_search(strtolower($needle), array_map('strtolower', $haystack));
    }

    function in_arrayi($needle, $haystack) {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

    function enleverAccents($chaine) {
        return strtr(utf8_decode($chaine), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
