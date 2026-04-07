<?php

namespace AreanetClp\Core\Content\AreanetClpGhs;

use AreanetClp\Core\Content\AreanetClpGhs\Aggregate\AreanetClpGhsTranslation\AreanetClpGhsTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class AreanetClpGhsDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'areanet_clp_ghs';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new StringField('name', 'name'),
            new TranslatedField('text'),
            new StringField('image', 'image'),
            new TranslationsAssociationField(
                AreanetClpGhsTranslationDefinition::class,
                'areanet_clp_ghs_id'
            )
        ]);
    }

    public function getEntityClass(): string
    {
        return AreanetClpGhsEntity::class;
    }

    public function getCollectionClass(): string
    {
        return AreanetClpGhsCollection::class;
    }
}
