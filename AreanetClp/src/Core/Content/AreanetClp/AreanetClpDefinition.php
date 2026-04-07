<?php

namespace AreanetClp\Core\Content\AreanetClp;

use AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpProduct\AreanetClpProductDefinition;
use AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpTranslation\AreanetClpTranslationDefinition;
use AreanetClp\Core\Content\AreanetClpGhs\AreanetClpGhsDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class AreanetClpDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'areanet_clp';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new TranslatedField('name'),
            new TranslatedField('text'),
            (new StringField('type', 'type'))->addFlags(new Required()),
            new StringField('signal_name', 'signalName'),
            new BoolField('imported', 'imported'),
            new TranslationsAssociationField(
                AreanetClpTranslationDefinition::class,
                'areanet_clp_id'
            ),
            new ManyToManyAssociationField(
                'products',
                ProductDefinition::class,
                AreanetClpProductDefinition::class,
                'areanet_clp_id',
                'product_id'),
            new FkField('areanet_clp_ghs_id', 'ghsId', AreanetClpGhsDefinition::class),
            new ManyToOneAssociationField('ghs', 'areanet_clp_ghs_id', AreanetClpGhsDefinition::class, 'id', false),
        ]);
    }

    public function getEntityClass(): string
    {
        return AreanetClpEntity::class;
    }

    public function getCollectionClass(): string
    {
        return AreanetClpCollection::class;
    }
}
