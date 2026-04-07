import './page/list';
import './page/detail';
import './page/create';

Shopware.Module.register('areanet-clp', {
    type: 'plugin',
    name: 'areanet-clp',
    title: 'areanet-clp.general.title',
    color: '#57d9a3',
    icon: 'regular-products',
    routes: {
        list: {
            component: 'areanet-clp-list',
            path: 'list'
        },
        detail: {
            component: 'areanet-clp-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'areanet.clp.list'
            }
        },
        create: {
            component: 'areanet-clp-create',
            path: 'create',
            meta: {
                parentPath: 'areanet.clp.list'
            }
        }
    },
    navigation: [{
        id: 'areanet-clp',
        label: 'areanet-clp.general.title',
        color: '#57d9a3',
        path: 'areanet.clp.list',
        icon: 'regular-products',
        parent: 'sw-catalogue',
        position: 10000
    }]
});
