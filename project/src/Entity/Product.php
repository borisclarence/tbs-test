<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_product;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detail_product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduct(): ?string
    {
        return $this->name_product;
    }

    public function setNameProduct(?string $name_product): self
    {
        $this->name_product = $name_product;

        return $this;
    }

    public function getDetailProduct(): ?string
    {
        return $this->detail_product;
    }

    public function setDetailProduct(?string $detail_product): self
    {
        $this->detail_product = $detail_product;

        return $this;
    }
}
