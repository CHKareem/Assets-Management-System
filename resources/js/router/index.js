import { createRouter, createWebHistory} from 'vue-router'

import Assets from '../pages/Assets.vue'
import NotFound from '../pages/NotFound.vue'
import Dashboard from '../pages/Dashboard.vue'
import ItemsTypes from '../pages/ItemsTypes.vue'
import Transports from '../pages/Transports.vue'
import LostStolen from '../pages/lostStolen.vue'
import Maintenance from '../pages/Maintenances.vue'
import Reports from '../pages/Reports.vue'


const routes = [
    {
        path: '/',
        component: Dashboard,
    },
    {
        path: '/assets',
        component: Assets,
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
    },
    {
        path: '/items-types',
        component: ItemsTypes,
    },
    {
        path: '/transports',
        component: Transports,
    },
    {
        path: '/lostStolen',
        component: LostStolen,
    },
    {
        path: '/maintenance',
        component: Maintenance,
    },
    {
        path: '/reports',
        component: Reports,
    }
]



const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router