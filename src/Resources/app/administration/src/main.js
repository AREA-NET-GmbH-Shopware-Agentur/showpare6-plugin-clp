import './module/areanet-clp';
import './extension/sw-product/view/sw-product-detail-base';
import './extension/sw-product/page/sw-product-detail';
import './component/form/field/my-custom-many-to-many-select';

Shopware.Component.override('sw-entity-many-to-many-select', {
    extendsComponent: 'my-custom-many-to-many-select'
});