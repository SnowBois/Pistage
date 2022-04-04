<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\EtudiantRepository;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/etudiant")
 */
class APIEtudiantController extends AbstractController
{
    const TABLEAU_ATTRIBUTS_ETUDIANT = ["id", "nom", "prenom", "numeroEtudiant", "numeroTelephone", "adresseMail", "premiereConnexion"];

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}&{nomParam5}={valeurParam5}", name="api_etudiant_5_param")
     */
    public function requete5param(EtudiantRepository $repositoryEtudiant, SerializerInterface $serializer, 
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

        if($this->in_arrayi($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT) 
        && $this->in_arrayi($nomParam2, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam3, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam4, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam5, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array(
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam1,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam1, 
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam2,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam2,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam3,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam3,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam4,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam4,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam5,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam5));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['etudiant','adresse', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}", name="api_etudiant_4_param")
     */
    public function requete4param(EtudiantRepository $repositoryEtudiant, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3,
                                    $nomParam4, $valeurParam4): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);
        $nomParam4 = $this->enleverAccents($nomParam4);

        if($this->in_arrayi($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT) 
        && $this->in_arrayi($nomParam2, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam3, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam4, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array(
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam1,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam1, 
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam2,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam2,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam3,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam3,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam4,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam4));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['etudiant','adresse', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}", name="api_etudiant_3_param")
     */
    public function requete3param(EtudiantRepository $repositoryEtudiant, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);

        if($this->in_arrayi($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT) 
        && $this->in_arrayi($nomParam2, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)
        && $this->in_arrayi($nomParam3, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array(
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam1,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam1, 
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam2,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam2,
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam3,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam3));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['etudiant','adresse', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}", name="api_etudiant_2_param")
     */
    public function requete2param(EtudiantRepository $repositoryEtudiant, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);

        if($this->in_arrayi($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT) 
        && $this->in_arrayi($nomParam2, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array(
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam1,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam1, 
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam2,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam2));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['etudiant','adresse', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}", name="api_etudiant_1_param")
     */
    public function requete1param(EtudiantRepository $repositoryEtudiant, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);

        if($this->in_arrayi($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array(
            APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT[$this->array_searchi($nomParam1,APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT)] => $valeurParam1));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['etudiant','adresse', 'cursus_sans_etudiants']]);

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
