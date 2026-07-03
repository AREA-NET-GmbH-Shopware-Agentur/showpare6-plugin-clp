import template from './areanet-clp-list.html.twig';
import './index.scss';

const { Component, Mixin, State, Context } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('areanet-clp-list', {
    template,

    inject: [
        'repositoryFactory'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            repository: null,
            items: null,
            ghs: {},
            term: null,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    computed: {
        areanetClpRepository() {
            return this.repositoryFactory.create('areanet_clp');
        },
        ghsRepository() {
            return this.repositoryFactory.create('areanet_clp_ghs');
        },

        columns() {
            return [
                {
                    property: 'name',
                    dataIndex: 'name',
                    label: this.$t('areanet-clp.list.columnName'),
                    routerLink: 'areanet.clp.detail',
                    primary: true
                },
                {
                    property: 'type',
                    dataIndex: 'type',
                    label: this.$t('areanet-clp.list.columnType')
                },
                {
                    property: 'ghsId',
                    label: this.$t('areanet-clp.list.columnImage')
                },
                {
                    property: 'text',
                    label: this.$t('areanet-clp.list.columnText'),
                },
                {
                    property: 'signalName',
                    dataIndex: 'signalName',
                    label: this.$t('areanet-clp.list.columnSignalName')
                },
                {
                    property: 'createdAt',
                    label: this.$t('areanet-clp.list.columnDate')
                }
            ];
        },
    },

    created() {
        this.repository = this.repositoryFactory.create('areanet_clp');
        this.getList();
        this.getGhs();
    },

    methods: {
        getList() {
            this.isLoading = true;

            const criteria = new Criteria();
            criteria.addSorting(Criteria.sort('name', 'ASC'));
            criteria.setLimit(10);

            if (this.term) {
                criteria.setTerm(this.term);
            }

            try {
                this.repository
                    .search(criteria, Context.api)
                    .then((result) => {
                        this.items = result;
                        this.isLoading = false;
                });

            } catch {
                this.isLoading = false;
            }
        },

        onSearch(term) {
            this.term = term;
            this.page = 1;

            this.getList();
        },

        onChangeLanguage(languageId) {
            State.commit('context/setApiLanguageId', languageId)
            this.getList();
        },

        formatDate(date) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: '2-digit'
            };
            return new Date(date).toLocaleDateString('de-DE', options);
        },

        generateDynamicTranslation(key, value) {
            const translationKey = `${key}_${value}`;
            return this.$tc(translationKey);
        },

        getGhs() {
            try {
                this.ghsRepository
                    .search(new Criteria(), Context.api)
                    .then((ghsEntities) => {
                        for (const item of ghsEntities) {
                            this.$set(this.ghs, item.id, item);
                        }
                    });
            } catch (error) {
                console.error('Fehler bei der GHS-Abfrage:', error);
            }
        }
    }
});
