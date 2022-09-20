import { createRouter, createWebHistory } from 'vue-router'

import WelcomePage from '../views/WelcomePage.vue'
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import Dashboard from '../views/DashboardPage.vue';
import PractisesPage from '../views/PractisesPage.vue';
import FieldsPage from '../views/FieldsPage.vue';
import WarehousePage from '../views/WarehousePage.vue';
import CropsPage from '../views/CropsPage.vue';
import ProfilePage from '../views/ProfilePage.vue';
import PlantProtectionProductPage from '../views/PlantProtectionProductPage.vue'

import store from '../store/index.js';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'welcome',
      component: WelcomePage
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage
    },
    {
      path: '/register',
      name: "register",
      component:RegisterPage
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: { requiresAuth: true }
    },
    {
      path: '/zabiegi-ochrony-roslin',
      name: 'practises',
      component: PractisesPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/grunty',
      name: 'fields',
      component: FieldsPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/magazyn',
      name: 'warehouse',
      component: WarehousePage,
      meta: { requiresAuth: true }
    },
    {
      path: '/uprawy',
      name: 'crops',
      component: CropsPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/profil',
      name: 'profile',
      component: ProfilePage,
      meta: { requiresAuth: true }
    },
    {
      path: '/srodek-ochrony-roslin/:id',
      name: 'ProductDetails',
      component: PlantProtectionProductPage,
      meta: { requiresAuth: true }
    }
  ]
});

router.beforeEach((to, _, next) => {
  if (to.meta.requiresAuth && !localStorage.getItem('isAuth')) {
    next('/login');
  }else {
    next();
  }
})

export default router
