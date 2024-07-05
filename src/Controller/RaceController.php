<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
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

#[Route('api/race', name: 'app_api_race_')]
class RaceController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager, 
        private RaceRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/new', name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {

        $race = $this->serializer->deserialize($request->getContent(), Race::class, 'json');
        $race->setCreatedAt(new DateTimeImmutable());
       
        $this->manager->persist($race);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($race, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_race_show',
            ['id' => $race->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {

        $race = $this->repository->findOneBy(['id' => $id]);
        if ($race) {
            $responseData = $this->serializer->serialize($race, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $race = $this->repository->findOneBy(['id' => $id]);
        if ($race) {
            $race->serializer-deserialize(
                $request->getContent(),
                Race::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $race]
            );
            $race->setUpdatedAt(new DateTimeImmutable());
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): JsonResponse
    {
        $race = $this->repository->findOneBy(['id' => $id]);
        if ($race) {
            $this->manager->remove($race);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}