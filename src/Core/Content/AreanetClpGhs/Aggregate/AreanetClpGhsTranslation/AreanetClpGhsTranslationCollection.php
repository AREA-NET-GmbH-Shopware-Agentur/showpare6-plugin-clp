<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClpGhs\Aggregate\AreanetClpGhsTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<AreanetClpGhsTranslationEntity>
 */
class AreanetClpGhsTranslationCollection extends EntityCollection {
    
    protected function getExpectedClass(): string
    {
        return AreanetClpGhsTranslationEntity::class;
    }
}
