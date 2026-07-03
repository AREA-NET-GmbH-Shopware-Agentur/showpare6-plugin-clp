const { Component, Context, State } = Shopware;
const { EntityCollection } = Shopware.Data;

Component.extend('areanet-clp-create', 'areanet-clp-detail', {
    created() {
        this.getEntity();
        this.entityId = null;
        if (Context.api.currentLanguageId !== Context.api.systemLanguageId) {
            State.commit('context/setApiLanguageId', Context.api.systemLanguageId)
        }
    },

    methods: {
        getEntity() {
            this.entity = this.repository.create(Context.api);
        },

        onChangeLanguage(languageId) {
            Shopware.State.commit('context/setApiLanguageId', languageId)
            this.getEntity();
        },

        saveOnLanguageChange() {
            return this.onClickSave();
        },

        abortOnLanguageChange() {

        },

        onClickSave() {
            this.isLoading = true;

            this.repository
                .save(this.entity, Context.api)
                .then(() => {
                    this.isLoading = false;
                    this.createNotificationSuccess({
                        title: this.$t('areanet-clp.notification.successTitle'),
                        message: this.$tc('areanet-clp.notification.success')
                    });
                    this.$router.push({name: 'areanet.clp.detail', params: {id: this.entity.id}});
                }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    title: this.$t('areanet-clp.notification.errorTitle'),
                    message: exception
                });
            });
        }
    }
});
