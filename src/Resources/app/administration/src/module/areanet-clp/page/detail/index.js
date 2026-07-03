import template from './areanet-clp-detail.html.twig';

const { Context, Component, State, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('areanet-clp-detail', {
    template,

    inject: [
        'repositoryFactory'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    data() {
        return {
            entityId: null,
            entity: null,
            isLoading: false,
            processSuccess: false,
            repository: null,
            typeOptions: [
                {
                    'id': 'areanet_clp_h',
                    'name': this.$tc('areanet-clp.detail.typeOptionHName'),
                },
                {
                    'id': 'areanet_clp_euh',
                    'name': this.$tc('areanet-clp.detail.typeOptionEuhName'),
                },
                {
                    'id': 'areanet_clp_p',
                    'name': this.$tc('areanet-clp.detail.typeOptionPName'),
                }
            ],
            signalOptions: [
                {
                    'id': 'attention',
                    'name': this.$tc('areanet-clp.detail.signal_attention')
                },
                {
                    'id': 'danger',
                    'name': this.$tc('areanet-clp.detail.signal_danger')
                }
            ]
        };
    },

    computed: {
        isDisabled() {
            return this.entity.imported;
        },
        ghsRepository() {
            return this.repositoryFactory.create('areanet_clp_ghs');
        },
        ghsAssignmentCriteria() {
            const criteria = new Criteria();

            criteria.addSorting(Criteria.sort('name', 'ASC'))

            return criteria;
        },
    },

    created() {
        this.repository = this.repositoryFactory.create('areanet_clp');
        this.getEntity();
    },

    methods: {
        getEntity() {
            this.repository
                .get(this.$route.params.id, Context.api)
                .then((entity) => {
                    this.entity = entity;
                    this.entityId = entity.id;

                    if(this.entity.ghsId) {
                        this.ghsRepository
                            .get(this.entity.ghsId, Context.api)
                            .then((ghsEntity) => {
                                this.entity.image = ghsEntity.image;
                                this.entity.ghsalt = ghsEntity.name;
                            });
                    }
                });
        },

        onSelectGhs(ghsId) {
            if(ghsId) {
                this.ghsRepository
                    .get(ghsId, Context.api)
                    .then((ghsEntity) => {
                        this.entity.image = ghsEntity.image;
                        this.entity.ghsalt = ghsEntity.name;

                    });
            } else {
                this.entity.image = '';
            }
        },

        onChangeLanguage(languageId) {
            State.commit('context/setApiLanguageId', languageId)
            this.getEntity();
        },

        saveOnLanguageChange() {
            return this.onClickSave();
        },

        abortOnLanguageChange() {
            this.getEntity();
            this.isLoading = false;
            this.processSuccess = false;
        },

        onClickSave() {
            this.isLoading = true;
            this.repository
                .save(this.entity, Context.api)
                .then(() => {
                    this.getEntity();
                    this.isLoading = false;
                    this.processSuccess = true;
                    this.createNotificationSuccess({
                        title: this.$t('areanet-clp.notification.successTitle'),
                        message: this.$tc('areanet-clp.notification.success')
                    });
                }).catch((exception) => {
                    this.isLoading = false;
                    this.createNotificationError({
                        title: this.$t('areanet-clp.notification.errorTitle'),
                        message: exception
                    });
                });
        },

        saveFinish() {
            this.processSuccess = false;
        },

        generateDynamicTranslation(key, value) {
            const translationKey = `${key}_${value}`;
            return this.$tc(translationKey);
        },

        //ToDo evtl. MEDIA
        onSetTitelbildItem({ targetId }) {
            this.mediaRepository.get(targetId, Shopware.Context.api).then((updatedMedia) => {
                this.pdfcatalogue.mediaId = targetId;
                this.pdfcatalogue.titelbild = updatedMedia;
            });
        },

        setTitelbild([mediaItem], mediaAssoc) {
            this.pdfcatalogue.mediaId = mediaItem.id;
            this.pdfcatalogue.titelbild = mediaItem;
        },

        onRemoveTitelbildItem() {
            this.pdfcatalogue.mediaId = null;
            this.pdfcatalogue.titelbild = null;
        },

        onMediaDropped(dropItem) {
            this.onSetTitelbildItem({ targetId: dropItem.id });
        },

        openMediaSidebar() {
            this.$parent.$parent.$parent.$parent.$refs.mediaSidebarItem.openContent();
        },

    }
});
