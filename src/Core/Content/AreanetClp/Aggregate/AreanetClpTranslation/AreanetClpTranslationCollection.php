<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<AreanetClpTranslationEntity>
 */
class AreanetClpTranslationCollection extends EntityCollection {
    
    protected function getExpectedClass(): string
    {
        return AreanetClpTranslationEntity::class;
    }
}
