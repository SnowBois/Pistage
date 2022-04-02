<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use App\Repository\EtudiantRepository;

/**
 * @Route("/api/etudiant")
 */
class APIEtudiantController extends AbstractController
{
    const TABLEAU_ATTRIBUTS_ETUDIANT = ["id", "nom", "prenom", "numeroEtudiant", "numeroTelephone", "adresseMail"];


    /**
     * @Route("/{nomParam1}={valeurParam1}", name="api_etudiant_1_param")
     */
    public function requete1param(EtudiantRepository $repositoryEtudiant, $nomParam1, $valeurParam1): JsonResponse
    {
        $nomParam1 = strtolower($nomParam1);
        $nomParam1 = $this->enleverAccents($nomParam1);

        if(in_array($nomParam1, APIEtudiantController::TABLEAU_ATTRIBUTS_ETUDIANT))
        {
            $resultat = $repositoryEtudiant->findBy(array($nomParam1 => $valeurParam1));
            
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($resultat, 'json');

            return new JsonResponse($jsonContent);
        }
        else
        {
            return new JsonResponse([
                'error' => 'Paramètre invalide.'
            ], 401);
        }
    }

    function enleverAccents($chaine) {
        return strtr(utf8_decode($chaine), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
