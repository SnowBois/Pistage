<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\RechercheRepository;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/recherche")
 */
class APIRechercheController extends AbstractController
{
    const TABLEAU_ATTRIBUTS_RECHERCHE = ["id", "observations"];

    /**
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}&{nomParam5}={valeurParam5}", name="api_recherche_5_param")
     */
    public function requete5param(RechercheRepository $repositoryRecherche, SerializerInterface $serializer, 
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

        if($this->in_arrayi($nomParam1, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE) 
        && $this->in_arrayi($nomParam2, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam3, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam4, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam5, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE))
        {
            $resultat = $repositoryRecherche->findBy(array(
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam1,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam1, 
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam2,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam2,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam3,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam3,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam4,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam4,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam5,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam5));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['recherche', 'etatrecherche', 'mediacontact', 'entreprise', 'service_sans_entreprise', 'adresse', 'employe_sans_entreprise', 'etudiant', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}&{nomParam4}={valeurParam4}", name="api_recherche_4_param")
     */
    public function requete4param(RechercheRepository $repositoryRecherche, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3,
                                    $nomParam4, $valeurParam4): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);
        $nomParam4 = $this->enleverAccents($nomParam4);

        if($this->in_arrayi($nomParam1, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE) 
        && $this->in_arrayi($nomParam2, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam3, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam4, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE))
        {
            $resultat = $repositoryRecherche->findBy(array(
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam1,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam1, 
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam2,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam2,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam3,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam3,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam4,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam4));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['recherche', 'etatrecherche', 'mediacontact', 'entreprise', 'service_sans_entreprise', 'adresse', 'employe_sans_entreprise', 'etudiant', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}&{nomParam3}={valeurParam3}", name="api_recherche_3_param")
     */
    public function requete3param(RechercheRepository $repositoryRecherche, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2,
                                    $nomParam3, $valeurParam3): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);
        $nomParam3 = $this->enleverAccents($nomParam3);

        if($this->in_arrayi($nomParam1, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE) 
        && $this->in_arrayi($nomParam2, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)
        && $this->in_arrayi($nomParam3, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE))
        {
            $resultat = $repositoryRecherche->findBy(array(
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam1,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam1, 
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam2,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam2,
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam3,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam3));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', ['groups' => ['recherche', 'etatrecherche', 'mediacontact', 'entreprise', 'service_sans_entreprise', 'adresse', 'employe_sans_entreprise', 'etudiant', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}&{nomParam2}={valeurParam2}", name="api_recherche_2_param")
     */
    public function requete2param(RechercheRepository $repositoryRecherche, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1,
                                    $nomParam2, $valeurParam2): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);
        $nomParam2 = $this->enleverAccents($nomParam2);

        if($this->in_arrayi($nomParam1, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE) 
        && $this->in_arrayi($nomParam2, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE))
        {
            $resultat = $repositoryRecherche->findBy(array(
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam1,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam1, 
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam2,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam2));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['recherche', 'etatrecherche', 'mediacontact', 'entreprise', 'service_sans_entreprise', 'adresse', 'employe_sans_entreprise', 'etudiant', 'cursus_sans_etudiants']]);

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
     * @Route("/{nomParam1}={valeurParam1}", name="api_recherche_1_param")
     */
    public function requete1param(RechercheRepository $repositoryRecherche, SerializerInterface $serializer, 
                                    $nomParam1, $valeurParam1): JsonResponse
    {
        $nomParam1 = $this->enleverAccents($nomParam1);

        if($this->in_arrayi($nomParam1, APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE))
        {
            $resultat = $repositoryRecherche->findBy(array(
            APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE[$this->array_searchi($nomParam1,APIRechercheController::TABLEAU_ATTRIBUTS_RECHERCHE)] => $valeurParam1));

            if ($resultat != null)
            {    
                $jsonContent = $serializer->serialize($resultat, 'json', 
                ['groups' => ['recherche', 'etatrecherche', 'mediacontact', 'entreprise', 'service_sans_entreprise', 'adresse', 'employe_sans_entreprise', 'etudiant', 'cursus_sans_etudiants']]);

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
