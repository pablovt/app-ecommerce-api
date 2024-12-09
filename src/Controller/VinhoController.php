<?php

namespace App\Controller;

use App\Entity\Vinho;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class VinhoController extends AbstractController
{
    #[Route('/api/vinhos', name: 'vinho_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $vinhos = $em->getRepository(Vinho::class)->findAll();
        $data = $serializer->serialize($vinhos, 'json', ['groups' => ['vinho:read']]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/vinhos', name: 'vinho_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $dados = json_decode($request->getContent(), true);

        if (!isset($dados['nome'], $dados['tipo'], $dados['peso'])) {
            return new JsonResponse(['error' => 'Dados incompletos.'], 400);
        }

        $vinho = new Vinho();
        $vinho->setNome($dados['nome']);
        $vinho->setTipo($dados['tipo']);
        $vinho->setPeso((float)$dados['peso']);

        $em->persist($vinho);
        $em->flush();

        $responseData = $serializer->serialize($vinho, 'json', ['groups' => ['vinho:read']]);
        return new JsonResponse($responseData, Response::HTTP_CREATED, [], true);
    }
}
