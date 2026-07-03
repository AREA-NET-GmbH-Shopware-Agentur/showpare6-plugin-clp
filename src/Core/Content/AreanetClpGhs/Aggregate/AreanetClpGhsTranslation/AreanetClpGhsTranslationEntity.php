<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClpGhs\Aggregate\AreanetClpGhsTranslation;

use AreanetClp\Core\Content\AreanetClpGhs\AreanetClpGhsEntity;
use Shopware\Core\Framework\DataAbstractionLayer\TranslationEntity;

class AreanetClpGhsTranslationEntity extends TranslationEntity {

    protected string $clpGhsId;

    protected ?string $text = null;

    protected ?AreanetClpGhsEntity $clpGhs = null;

    public function getClpGhsId(): string
    {
        return $this->clpGhsId;
    }

    public function setClpGhsId(string $clpGhsId): void
    {
        $this->clpGhsId = $clpGhsId;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getClpGhs(): ?AreanetClpGhsEntity
    {
        return $this->clpGhs;
    }

    public function setClpGhs(AreanetClpGhsEntity $clpGhs): void
    {
        $this->clpGhs = $clpGhs;
    }



}
