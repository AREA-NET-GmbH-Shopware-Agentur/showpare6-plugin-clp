const { Component } = Shopware;

Component.extend('my-custom-many-to-many-select', 'sw-entity-many-to-many-select', {
    computed: {
        visibleValues() {
            if (!this.entityCollection || this.entityCollection.length <= 0) {
                return [];
            }

            this.entityCollection.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });

            return this.entityCollection.slice(0, this.displayItemLimit);
        },
    }
});
