<?php

namespace App\Entity;

use App\Repository\VendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VendaRepository::class)]
class Venda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['venda:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['venda:write', 'venda:read', 'vendaProduto:read'])]
    private ?float $distancia = null;

    #[ORM\Column]
    #[Groups(['venda:write', 'venda:read', 'vendaProduto:read'])]
    private ?float $valorFrete = null;

    #[ORM\Column]
    #[Groups(['venda:write', 'venda:read', 'vendaProduto:read'])]
    private ?float $total = null;

    #[ORM\OneToMany(targetEntity: VendaProduto::class, mappedBy: 'venda', cascade: ['persist', 'remove'])]
    private Collection $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistancia(): ?float
    {
        return $this->distancia;
    }

    public function setDistancia(float $distancia): static
    {
        $this->distancia = $distancia;

        return $this;
    }

    public function getValorFrete(): ?float
    {
        return $this->valorFrete;
    }

    public function setValorFrete(float $valorFrete): static
    {
        $this->valorFrete = $valorFrete;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(VendaProduto $produto): static
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos->add($produto);
            $produto->setVenda($this);
        }

        return $this;
    }

    public function removeProduto(VendaProduto $produto): static
    {
        if ($this->produtos->removeElement($produto)) {
            if ($produto->getVenda() === $this) {
                $produto->setVenda(null);
            }
        }

        return $this;
    }

    public function calcularFrete(): void
    {
        $pesoTotal = 0;
        foreach ($this->produtos as $produto) {
            $pesoTotal += $produto->getProduto()->getPeso() * $produto->getQuantidade();
        }

        if ($this->distancia <= 100) {
            $this->valorFrete = $pesoTotal * 5;
        } else {
            $this->valorFrete = $pesoTotal * 5 * ($this->distancia / 100);
        }
    }

    public function calcularTotal(): void
    {
        $totalProdutos = 0;
        foreach ($this->produtos as $produto) {
            $totalProdutos += $produto->getProduto()->getPreco() * $produto->getQuantidade();
        }

        $this->total = $totalProdutos + $this->valorFrete;
    }
}
