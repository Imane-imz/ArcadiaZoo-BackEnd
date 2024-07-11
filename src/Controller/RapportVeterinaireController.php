<?php

namespace App\Controller;

use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;
use DateTimeImmutable;
use Doctrine\Migrations\Configuration\Migration\JsonFile;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/rapportveterinaire', name: 'app_api_rapportveterinaire_')]
class RapportVeterinaireController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager, 
        private RapportVeterinaireRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/new', name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {

        $rapportveterinaire = $this->serializer->deserialize($request->getContent(), RapportVeterinaire::class, 'json');
        $rapportveterinaire->setCreatedAt(new DateTimeImmutable());
       
        $this->manager->persist($rapportveterinaire);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($rapportveterinaire, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_rapportveterinaire_show',
            ['id' => $rapportveterinaire->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {

        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);
        if ($rapportveterinaire) {
            $responseData = $this->serializer->serialize($rapportveterinaire, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);
        if ($rapportveterinaire) {
            $rapportveterinaire=$this->serializer->deserialize(
                $request->getContent(),
                RapportVeterinaire::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $rapportveterinaire]
            );
            $rapportveterinaire->setUpdatedAt(new DateTimeImmutable());
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): JsonResponse
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);
        if ($rapportveterinaire) {
            $this->manager->remove($rapportveterinaire);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}