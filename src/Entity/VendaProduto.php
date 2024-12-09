<?php

namespace App\Entity;

use App\Repository\VendaProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VendaProdutoRepository::class)]
class VendaProduto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vendaProduto:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Venda::class, inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vendaProduto:read'])]
    private ?Venda $venda = null;

    #[ORM\ManyToOne(targetEntity: Vinho::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vendaProduto:read'])]
    private ?Vinho $produto = null;

    #[ORM\Column]
    #[Groups(['vendaProduto:read'])]
    private ?int $quantidade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenda(): ?Venda
    {
        return $this->venda;
    }

    public function setVenda(?Venda $venda): static
    {
        $this->venda = $venda;

        return $this;
    }

    public function getProduto(): ?Vinho
    {
        return $this->produto;
    }

    public function setProduto(?Vinho $produto): static
    {
        $this->produto = $produto;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }
}
