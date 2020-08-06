<?php

namespace App\Entity;

use App\Repository\SoftwareRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoftwareRepository::class)
 */
class Software
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="software")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Product;

    /**
     * @ORM\ManyToOne(targetEntity=Platform::class, inversedBy="software")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Platform;

    /**
     * @ORM\Column(type="float")
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $download_path;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->Platform;
    }

    public function setPlatform(?Platform $Platform): self
    {
        $this->Platform = $Platform;

        return $this;
    }

    public function getVersion(): ?float
    {
        return $this->version;
    }

    public function setVersion(float $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getDownloadPath(): ?string
    {
        return $this->download_path;
    }

    public function setDownloadPath(string $download_path): self
    {
        $this->download_path = $download_path;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function __toString()
    {
        return $this->download_path;
    }

}
