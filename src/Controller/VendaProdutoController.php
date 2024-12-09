<?php

namespace App\Controller;

use App\Entity\VendaProduto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class VendaProdutoController extends AbstractController
{
    #[Route('/api/vendaProdutos', name: 'venda_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $vendas = $em->getRepository(VendaProduto::class)->findAll();
        $data = $serializer->serialize($vendas, 'json', ['groups' => ['vendaProduto:read']]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
