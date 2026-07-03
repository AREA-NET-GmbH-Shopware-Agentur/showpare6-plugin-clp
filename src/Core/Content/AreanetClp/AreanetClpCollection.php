<?php

namespace AreanetClp\Core\Content\AreanetClp;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<AreanetClpEntity>
 */
class AreanetClpCollection extends EntityCollection
{
    public function getExpectedClass(): string
    {
        return AreanetClpEntity::class;
    }
}
