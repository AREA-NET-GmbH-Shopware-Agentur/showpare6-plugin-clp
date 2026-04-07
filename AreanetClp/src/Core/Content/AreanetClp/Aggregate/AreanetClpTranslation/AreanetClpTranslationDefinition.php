<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpTranslation;

use AreanetClp\Core\Content\AreanetClp\AreanetClpDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\{EntityTranslationDefinition,
    Field\Flag\AllowHtml,
    Field\Flag\Required,
    Field\StringField,
    FieldCollection};

class AreanetClpTranslationDefinition extends EntityTranslationDefinition {

    public const ENTITY_NAME = 'areanet_clp_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return AreanetClpTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return AreanetClpTranslationEntity::class;
    }

    public function getParentDefinitionClass(): string
    {
        return AreanetClpDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name', 1000))->addFlags(new Required()),
            (new StringField('text', 'text', 1000))->addFlags(new Required(), new AllowHtml(false))
        ]);
    }

}
