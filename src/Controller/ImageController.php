<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
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

#[Route('api/image', name: 'app_api_image_')]
class ImageController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager, 
        private ImageRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/new', name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {

        $image = $this->serializer->deserialize($request->getContent(), Image::class, 'json');
        $image->setCreatedAt(new DateTimeImmutable());
       
        $this->manager->persist($image);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($image, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_image_show',
            ['id' => $image->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {

        $image = $this->repository->findOneBy(['id' => $id]);
        if ($image) {
            $responseData = $this->serializer->serialize($image, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $image = $this->repository->findOneBy(['id' => $id]);
        if ($image) {
            $image->serializer-deserialize(
                $request->getContent(),
                Image::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $image]
            );
            $image->setUpdatedAt(new DateTimeImmutable());
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): JsonResponse
    {
        $image = $this->repository->findOneBy(['id' => $id]);
        if ($image) {
            $this->manager->remove($image);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}