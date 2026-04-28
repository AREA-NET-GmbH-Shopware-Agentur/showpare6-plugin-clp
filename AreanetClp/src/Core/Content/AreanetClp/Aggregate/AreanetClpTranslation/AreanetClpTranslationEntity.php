<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpTranslation;

use AreanetClp\Core\Content\AreanetClp\AreanetClpEntity;
use Shopware\Core\Framework\DataAbstractionLayer\TranslationEntity;

class AreanetClpTranslationEntity extends TranslationEntity {

    protected string $clpId;

    protected ?string $text = null;

    protected ?string $signalName = null;

    protected ?AreanetClpEntity $clp = null;

    /**
     * @return string
     */
    public function getClpId(): string
    {
        return $this->clpId;
    }

    public function setClpId(string $clpId): void
    {
        $this->clpId = $clpId;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getClp(): ?AreanetClpEntity
    {
        return $this->clp;
    }

    public function setClp(AreanetClpEntity $clp): void
    {
        $this->clp = $clp;
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
