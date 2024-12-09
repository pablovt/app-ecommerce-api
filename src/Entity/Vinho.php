<?php

namespace App\Entity;

use App\Repository\VinhoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VinhoRepository::class)]
class Vinho
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vinho:read', 'vendaProduto:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['vinho:write', 'vinho:read'])]
    private ?string $nome = null;

    #[ORM\Column(type: Types::STRING, length: 150)]
    #[Groups(['vinho:write', 'vinho:read'])]
    private ?string $tipo = null;

    #[ORM\Column]
    #[Groups(['vinho:write', 'vinho:read'])]
    private ?float $peso = null;

    #[ORM\Column(length: 100)]
    private ?string $preco = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getPreco(): ?string
    {
        return (float) $this->preco;
    }

    public function setPreco(string $preco): static
    {
        $this->preco = $preco;

        return $this;
    }
}
