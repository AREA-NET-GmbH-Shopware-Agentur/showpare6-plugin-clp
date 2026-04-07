<?php

namespace AreanetClp\Core\Content\AreanetClpGhs;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class AreanetClpGhsEntity extends Entity
{
    use EntityIdTrait;

    protected ?string $name;
    protected ?string $image;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}
