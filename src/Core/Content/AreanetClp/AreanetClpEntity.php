<?php

namespace AreanetClp\Core\Content\AreanetClp;

use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class AreanetClpEntity extends Entity
{
    use EntityIdTrait;

    protected ?string $name;
    protected ?string $text;
    protected ?string $type;
    protected ?string $signalName;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getSignalName(): ?string
    {
        return $this->signalName;
    }

    public function setSignalName(?string $signalName): void
    {
        $this->signalName = $signalName;
    }



}
