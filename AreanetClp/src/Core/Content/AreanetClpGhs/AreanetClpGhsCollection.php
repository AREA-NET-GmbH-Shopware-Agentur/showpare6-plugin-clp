<?php

namespace AreanetClp\Core\Content\AreanetClpGhs;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<AreanetClpGhsEntity>
 */
class AreanetClpGhsCollection extends EntityCollection
{
    public function getExpectedClass(): string
    {
        return AreanetClpGhsEntity::class;
    }
}
