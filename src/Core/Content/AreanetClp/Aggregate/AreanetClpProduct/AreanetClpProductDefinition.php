<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClp\Aggregate\AreanetClpProduct;

use AreanetClp\Core\Content\AreanetClp\AreanetClpDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\{FieldCollection, MappingEntityDefinition,};
use Shopware\Core\Framework\DataAbstractionLayer\Field\{CreatedAtField,
    FkField,
    Flag\PrimaryKey,
    Flag\Required,
    ManyToOneAssociationField,
    ReferenceVersionField};

class AreanetClpProductDefinition extends MappingEntityDefinition {

    public function getEntityName(): string 
    {
        return 'areanet_clp_product';
    }

    public function defineFields(): FieldCollection 
    {
        $fields = [];

        array_push($fields, (new FkField(
                                'areanet_clp_id',
                                'clpId',
                                AreanetClpDefinition::class
                            ))->addFlags(
                                new PrimaryKey(), 
                                new Required()
                            ));

        array_push($fields, (new FkField(
                                'product_id',
                                'productId', 
                                ProductDefinition::class
                            ))->addFlags(
                                new PrimaryKey(), 
                                new Required()
                            ));


        array_push($fields, (new ReferenceVersionField(
                                ProductDefinition::class
                            ))->addFlags(
                                new PrimaryKey(),
                                new Required()
                            )
                        );

        array_push($fields, new ManyToOneAssociationField(
            'clp',
            'areanet_clp_id',
            AreanetClpDefinition::class
        ));

        array_push($fields, new ManyToOneAssociationField(
            'product',
            'product_id',
            ProductDefinition::class
        ));

        array_push($fields, new CreatedAtField());

        return new FieldCollection($fields);

    }

}
