import template from './sw-product-detail-base.html.twig';
import './index.scss';

const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-product-detail-base', {
    template,

    data() {
        return {
            areanetClpSystemConfigValues: {
                showAdminProductClpAssignment: false,
            },
            textFields : {}
        }
    },

    mounted() {
        this.loadClpProductData();
    },

    computed: {
        productRepository() {
            return this.repositoryFactory.create('product');
        },

        AreanetClpProductAssignmentCriteria() {
            const criteria = new Criteria();

            criteria.addSorting(Criteria.sort('name', 'ASC'));
            criteria.addAssociation('ghs');

            return criteria;
        }
    },

    methods: {
        createdComponent() {
            this.systemConfigRepository = this.repositoryFactory.create('system_config');
            this.areanetClpLoadConfig();

            this.$super('createdComponent');
        },

        handleUpdate(entityCollection, props) {
            if (props && typeof props.updateCurrentValue === 'function') {
                props.updateCurrentValue(entityCollection);
            }

            this.getCustomFields(entityCollection);
        },

        areanetClpLoadConfig() {
            var me = this;

            var criteria = new Criteria();
            criteria.addFilter(
                Criteria.equalsAny(
                    'configurationKey',
                    [
                        'AreanetClp.config.showAdminProductClpAssignment',
                    ]
                )
            );

            me.systemConfigRepository.search(criteria)
                .then((result) => {

                    result.forEach(element => {
                        me.$set(
                            me.areanetClpSystemConfigValues,
                            element.configurationKey.replace('AreanetClp.config.', ''),
                            element.configurationValue
                        );
                    })
                });
        },

         async loadClpProductData() {
             const entity = await this.productRepository.get(this.$store.state.swProductDetail.productId, Shopware.Context.api, new Criteria().addAssociation('areanetClp').addAssociation('areanetClp.ghs'));
             this.getCustomFields(entity.extensions.areanetClp, entity);
        },

        getCustomFields(selectedItems, product) {
            selectedItems.sort((a, b) => a.name.localeCompare(b.name));

            if(product) {
                this.$set(this.product, product);
            }

            if(this.product.customFields && !this.product.customFields.hasOwnProperty('areanet_clp')) {
                this.$set(this.product.customFields, 'areanet_clp', {});
                this.$set(this.product.customFields.areanet_clp, 'init', "1");
            }
            selectedItems.some(item => {
                const var1 = this.textFields.hasOwnProperty(item.name + '_var1');
                const var2 = this.textFields.hasOwnProperty(item.name + '_var2');
                const labeltext = item.text.replace('%var1%','').replace('%var2%','');

                if(item.text.includes("%var1%") && !var1) {
                    let key = item.name + '_var1';
                    let label = item.name;
                    if(item.text.includes("%var2%")) {
                        label = item.name + ' VAR1';
                    }
                    this.$set(this.textFields, key, {label: label, text: labeltext, item:item});
                }

                if(item.text.includes("%var2%") && !var2) {
                    let key = item.name + '_var2';
                    this.$set(this.textFields, key, {label: item.name + ' VAR2', text: labeltext, item:item});
                }
            });
            this.textFields = Object.entries(this.textFields)
                .map(([key, content]) => ({ key, content}))
                .sort((a, b) => a.key.localeCompare(b.key))
                .reduce((obj, { key, content }) => {
                    obj[key] = content;
                    return obj;
                }, {});
            Object.keys(this.textFields).forEach(key => {
                const itemFieldVar1 = selectedItems.find(item => item.name + '_var1' === key);
                const itemFieldVar2 = selectedItems.find(item => item.name + '_var2' === key);
                const text = this.textFields[key].item.text;
                if(
                    (itemFieldVar1 === undefined && !text.includes("%var2%")) ||
                    (itemFieldVar1 === undefined && itemFieldVar2 === undefined)
                ) {
                    delete this.textFields[key]
                }
            });
        }
    }
});
