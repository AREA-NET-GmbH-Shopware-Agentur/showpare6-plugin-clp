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

    watch: {
        // The product comes from the Pinia store and is loaded asynchronously; on a page reload
        // it is not ready yet at mount time. Build the var fields once the areanetClp association
        // (loaded via the sw-product-detail productCriteria override) is available. `immediate`
        // also covers the case where the product is already present (e.g. entering an open tab).
        'product.extensions.areanetClp': {
            handler(collection) {
                if (collection) {
                    this.getCustomFields(collection);
                }
            },
            immediate: true,
        },
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
                        // Vue 3 (Shopware 6.7): $set was removed; direct assignment is reactive via Proxy.
                        me.areanetClpSystemConfigValues[element.configurationKey.replace('AreanetClp.config.', '')] = element.configurationValue;
                    })
                });
        },

        getCustomFields(selectedItems) {
            // May be called before the store product is ready (reload) or with an empty selection.
            if (!this.product || !selectedItems) {
                return;
            }

            selectedItems.sort((a, b) => (a.name ?? '').localeCompare(b.name ?? ''));

            // Products without any custom fields have customFields === null; the template binds
            // product.customFields.areanet_clp[key], so both levels must exist to avoid a TypeError.
            if(!this.product.customFields) {
                this.product.customFields = {};
            }
            if(!this.product.customFields.hasOwnProperty('areanet_clp')) {
                this.product.customFields.areanet_clp = { init: "1" };
            }
            selectedItems.some(item => {
                // Translated field: may be null for the current language; skip such items.
                if (!item.text) {
                    return false;
                }
                const var1 = this.textFields.hasOwnProperty(item.name + '_var1');
                const var2 = this.textFields.hasOwnProperty(item.name + '_var2');
                const labeltext = item.text.replace('%var1%','').replace('%var2%','');

                if(item.text.includes("%var1%") && !var1) {
                    let key = item.name + '_var1';
                    let label = item.name;
                    if(item.text.includes("%var2%")) {
                        label = item.name + ' VAR1';
                    }
                    this.textFields[key] = {label: label, text: labeltext, item:item};
                }

                if(item.text.includes("%var2%") && !var2) {
                    let key = item.name + '_var2';
                    this.textFields[key] = {label: item.name + ' VAR2', text: labeltext, item:item};
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
                const text = this.textFields[key].item.text ?? '';
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
