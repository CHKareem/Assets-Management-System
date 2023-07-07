import { createRouter, createWebHistory} from 'vue-router'
import store from '../store.js'
import Assets from '../pages/Assets.vue'
import NotFound from '../pages/NotFound.vue'
import Dashboard from '../pages/Dashboard.vue'
import ItemsTypes from '../pages/ItemsTypes.vue'
import Transports from '../pages/Transports.vue'
import LostStolen from '../pages/lostStolen.vue'
import Maintenance from '../pages/Maintenances.vue'
import Reports from '../pages/Reports.vue'
import Login from '../pages/Login.vue'


const routes = [
    {
        path: '/login',
        component: Login,
        meta: {guest: true}
    },
    {
        path: '/',
        component: Dashboard,
        meta: {requiresAuth: true}
    },
    {
        path: '/assets',
        component: Assets,
        meta: {requiresAuth: true}
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
        meta: {requiresAuth: true}
    },
    {
        path: '/items-types',
        component: ItemsTypes,
        meta: {requiresAuth: true}
    },
    {
        path: '/transports',
        component: Transports,
        meta: {requiresAuth: true}
    },
    {
        path: '/lostStolen',
        component: LostStolen,
        meta: {requiresAuth: true}
    },
    {
        path: '/maintenance',
        component: Maintenance,
        meta: {requiresAuth: true}
    },
    {
        path: '/reports',
        component: Reports,
        meta: {requiresAuth: true}
    }
]



const router = createRouter({
    history: createWebHistory(),
    routes
})


router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
      if (store.getters.isAuthenticated) {
        next();
        return;
      }
      next("/login");
    } else {
      next();
    }
  });
  
  router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
      if (store.getters.isAuthenticated) {
        next("/");
        return;
      }
      next();
    } else {
      next();
    }
  });

export default router