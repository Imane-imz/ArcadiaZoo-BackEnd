<?php

namespace App\Controller;

use App\Entity\HabitatImage;
use App\Repository\HabitatImageRepository;
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

#[Route('api/habitatimage', name: 'app_api_habitatimage_')]
class HabitatImageController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager, 
        private HabitatImageRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/new', name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {

        $habitatimage = $this->serializer->deserialize($request->getContent(), HabitatImage::class, 'json');
        $habitatimage->setCreatedAt(new DateTimeImmutable());
       
        $this->manager->persist($habitatimage);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($habitatimage, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_habitatimage_show',
            ['id' => $habitatimage->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {

        $habitatimage = $this->repository->findOneBy(['id' => $id]);
        if ($habitatimage) {
            $responseData = $this->serializer->serialize($habitatimage, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $habitatimage = $this->repository->findOneBy(['id' => $id]);
        if ($habitatimage) {
            $habitatimage->serializer-deserialize(
                $request->getContent(),
                HabitatImage::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $habitatimage]
            );
            $habitatimage->setUpdatedAt(new DateTimeImmutable());
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): JsonResponse
    {
        $habitatimage = $this->repository->findOneBy(['id' => $id]);
        if ($habitatimage) {
            $this->manager->remove($habitatimage);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}