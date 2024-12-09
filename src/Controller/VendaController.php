<?php

namespace App\Controller;

use App\Entity\Venda;
use App\Entity\VendaProduto;
use App\Entity\Vinho;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class VendaController extends AbstractController
{
    #[Route('/api/vendas', name: 'venda_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $dados = json_decode($request->getContent(), true);

        $venda = new Venda();
        $venda->setDistancia($dados['distancia']);

        foreach ($dados['produtos'] as $produtoData) {
            $vinho = $em->getRepository(Vinho::class)->find($produtoData['id']);
            $vendaProduto = new VendaProduto();
            $vendaProduto->setProduto($vinho);
            $vendaProduto->setQuantidade($produtoData['quantidade']);
            $venda->addProduto($vendaProduto);
        }

        $venda->calcularFrete();
        $venda->calcularTotal();

        $em->persist($venda);
        $em->flush();

        return new JsonResponse(['message' => 'Venda registrada com sucesso!'], Response::HTTP_CREATED);
    }

    #[Route('/api/vendas', name: 'venda_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $vendas = $em->getRepository(Venda::class)->findAll();
        $data = $serializer->serialize($vendas, 'json', ['groups' => ['venda:read']]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }  
}
