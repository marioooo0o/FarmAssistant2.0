<template>
    <Navbar />
        <div v-if="hasFarm" class="grid grid-cols-2 h-full w-full">
            <FieldsPage />
            <PractisesPage />
            <div class="col-span-2">
                <WarehousePage />
            </div>
        </div>
        <AddFarm v-else  />
</template>
<script>
import { ref, computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue'
import AddFarm from '../components/fams/AddFarm.vue'
import ResponseModal from '../components/ui/ResponseModal.vue';
import FieldsPage from './FieldsPage.vue';
import PractisesPage from './PractisesPage.vue';
import WarehousePage from './WarehousePage.vue';
export default {
    components: { Navbar, AddFarm, ResponseModal, FieldsPage, PractisesPage, WarehousePage },
    setup(props){
        const store = useStore();
        const route = useRoute();
        const router = useRouter();

        onBeforeMount(async() => {
                store.commit('toggleLoading');
                const response = await store.dispatch('auth/loadUserProfile');
                console.log('resuserprofile dashboard', response);
                if(response && response.status === 401){
                    router.replace('/login');
                }
                store.commit('toggleLoading');
            
        });

        const hasFarm = computed(() => {
            return store.getters['farm/hasFarm'];
        });

        return {
            hasFarm,
        }
    }
}
</script>
