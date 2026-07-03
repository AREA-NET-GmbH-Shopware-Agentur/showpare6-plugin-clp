<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\Product;

use AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpProduct\AreanetClpProductDefinition;
use AreanetClp\Core\Content\AreanetClp\AreanetClpDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\{EntityExtension,
    Field\Flag\Inherited,
    Field\ManyToManyAssociationField,
    FieldCollection};

class ProductExtension extends EntityExtension {

    public function extendFields(FieldCollection $fields): void
    {
        $fields->add(
            (new ManyToManyAssociationField(
                'areanetClp',
                AreanetClpDefinition::class,
                AreanetClpProductDefinition::class,
                'product_id',
                'areanet_clp_id'
            ))->addFlags(new Inherited())
        );
    }

    public function getEntityName(): string
    {
        return ProductDefinition::ENTITY_NAME;
    }

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}
