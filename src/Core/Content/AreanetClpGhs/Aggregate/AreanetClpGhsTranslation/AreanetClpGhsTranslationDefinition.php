<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClpGhs\Aggregate\AreanetClpGhsTranslation;

use AreanetClp\Core\Content\AreanetClpGhs\AreanetClpGhsDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\{EntityTranslationDefinition,
    Field\StringField,
    FieldCollection};

class AreanetClpGhsTranslationDefinition extends EntityTranslationDefinition {

    public const ENTITY_NAME = 'areanet_clp_ghs_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return AreanetClpGhsTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return AreanetClpGhsTranslationEntity::class;
    }

    public function getParentDefinitionClass(): string
    {
        return AreanetClpGhsDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            new StringField('text', 'text', 1000)
        ]);
    }

}
