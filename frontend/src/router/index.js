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
      component: Dashboard
    },
    {
      path: '/zabiegi-ochrony-roslin',
      name: 'practises',
      component: PractisesPage
    },
    {
      path: '/grunty',
      name: 'fields',
      component: FieldsPage
    },
    {
      path: '/magazyn',
      name: 'warehouse',
      component: WarehousePage
    },
    {
      path: '/uprawy',
      name: 'crops',
      component: CropsPage
    },
    {
      path: '/profil',
      name: 'profile',
      component: ProfilePage
    },
    {
      path: '/srodek-ochrony-roslin/:id',
      name: 'ProductDetails',
      component: PlantProtectionProductPage,
    }
  ]
})

export default router
