<template>
    <Navbar />
        <div v-if="hasFarm" class="grid grid-cols-2 h-full w-full">
            <FieldsPage />
            <PractiseList />
        </div>
        <AddFarm v-else  />
</template>
<script>
import { ref, computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import Navbar from '../components/navbar/TheNavbar.vue'
import AddFarm from '../components/fams/AddFarm.vue'
import ResponseModal from '../components/ui/ResponseModal.vue';
import FieldList from '../components/fields/FieldList.vue';
import PractiseList from '../components/practises/PractiseList.vue';
import FieldsPage from './FieldsPage.vue';
export default {
    components: { Navbar, AddFarm, ResponseModal, FieldList, PractiseList, FieldsPage },
    setup(props){
        const store = useStore();

        onBeforeMount(async() => {
                store.commit('toggleLoading');
                const response = await store.dispatch('auth/loadUserProfile');
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
