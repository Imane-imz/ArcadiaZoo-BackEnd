<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
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

#[Route('api/users', name: 'app_api_users_')]
class UsersController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager, 
        private UsersRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/new', name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {

        $users = $this->serializer->deserialize($request->getContent(), Users::class, 'json');
        $users->setCreatedAt(new DateTimeImmutable());
       
        $this->manager->persist($users);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($users, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_users_show',
            ['id' => $users->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {

        $users = $this->repository->findOneBy(['id' => $id]);
        if ($users) {
            $responseData = $this->serializer->serialize($users, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $users = $this->repository->findOneBy(['id' => $id]);
        if ($users) {
            $users->serializer-deserialize(
                $request->getContent(),
                Users::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $users]
            );
            $users->setUpdatedAt(new DateTimeImmutable());
            
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }


    #[Route('/{$id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): JsonResponse
    {
        $users = $this->repository->findOneBy(['id' => $id]);
        if ($users) {
            $this->manager->remove($users);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}