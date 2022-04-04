<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\EntrepriseRepository;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/entreprise")
 */
class APIEntrepriseController extends AbstractController
{
    const TABLEAU_ATTRIBUTS_ENTREPRISE = ["id", "nom", "numeroTelephone", "typeEtablissement", "activite", "numeroSIRET", "codeAPEouNAF", "statutJuridique", "effectif", "numeroFax", "adresseMail", "siteWeb"];

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}&{nomParam5}={valeurParam5}", name="api_entreprise_5_param")
     */
    public function requete5param(EntrepriseRepository $repositoryEntreprise, SerializerInterface $serializer, 
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

        if($this->in_arrayi($nomParam1, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE) 
        && $this->in_arrayi($nomParam2, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam3, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam4, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam5, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE))
        {
            $resultat = $repositoryEntreprise->findBy(array(
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam1,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam1, 
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam2,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam2,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam3,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam3,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam4,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam4,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam5,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam5));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['entreprise', 'adresse', 'employe_sans_entreprise', 'service_sans_entreprise']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}", name="api_entreprise_4_param")
     */
    public function requete4param(EntrepriseRepository $repositoryEntreprise, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3,
                                    $nomParam4, $valeurParam4): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);
        $nomParam4 = $this->enleverAccents($nomParam4);

        if($this->in_arrayi($nomParam1, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE) 
        && $this->in_arrayi($nomParam2, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam3, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam4, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE))
        {
            $resultat = $repositoryEntreprise->findBy(array(
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam1,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam1, 
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam2,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam2,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam3,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam3,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam4,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam4));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['entreprise', 'adresse', 'employe_sans_entreprise', 'service_sans_entreprise']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}", name="api_entreprise_3_param")
     */
    public function requete3param(EntrepriseRepository $repositoryEntreprise, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);

        if($this->in_arrayi($nomParam1, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE) 
        && $this->in_arrayi($nomParam2, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)
        && $this->in_arrayi($nomParam3, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE))
        {
            $resultat = $repositoryEntreprise->findBy(array(
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam1,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam1, 
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam2,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam2,
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam3,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam3));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['entreprise', 'adresse', 'employe_sans_entreprise', 'service_sans_entreprise']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}", name="api_entreprise_2_param")
     */
    public function requete2param(EntrepriseRepository $repositoryEntreprise, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);

        if($this->in_arrayi($nomParam1, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE) 
        && $this->in_arrayi($nomParam2, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE))
        {
            $resultat = $repositoryEntreprise->findBy(array(
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam1,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam1, 
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam2,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam2));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['entreprise', 'adresse', 'employe_sans_entreprise', 'service_sans_entreprise']]);

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
     * @Route("/{nomParam1}={valeurParam1}", name="api_entreprise_1_param")
     */
    public function requete1param(EntrepriseRepository $repositoryEntreprise, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);

        if($this->in_arrayi($nomParam1, APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE))
        {
            $resultat = $repositoryEntreprise->findBy(array(
            APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE[$this->array_searchi($nomParam1,APIEntrepriseController::TABLEAU_ATTRIBUTS_ENTREPRISE)] => $valeurParam1));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['entreprise', 'adresse', 'employe_sans_entreprise', 'service_sans_entreprise']]);

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
