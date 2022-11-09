<template>
    <Navbar v-if="isPractisePage"/>
    <PractiseList
        :practisesList="practisesList"
        @show-description-page=showDescriptionPage
        @show-create-page="showCreatePage" />
    <PractiseDescription v-if="activeComponent == 'descriptionPractise'"
        :practise="activePractise"
        @close-description-card="showProductListPage" />
    <AddPractise v-else-if="activeComponent == 'createPractise'"
        @close-add-card="showProductListPage"/>
</template>
<script>
import { ref, computed, provide, watch, onBeforeMount, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue';
import PractiseList from '../components/practises/PractiseList.vue';
import PractiseDescription from '../components/practises/PractiseDescription.vue';
import AddPractise from '../components/practises/AddPractise.vue';
export default {
    components: { Navbar, PractiseList, PractiseDescription, AddPractise },
    setup(props) {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();

        const activeComponent = ref('practiseList');
        const lastCreateOrEdit = ref(null);

        const practiseId = ref(null);
        onBeforeMount(async() => {
            store.commit('toggleLoading');
            const responseUserProfile = await store.dispatch('auth/loadUserProfile');
            console.log('resuserprofile practises', responseUserProfile);
            if (responseUserProfile && responseUserProfile.status === 401) {
                router.replace('/login');
            }
            const responsePractises = await store.dispatch('practises/loadPractises');
            if(responsePractises && responsePractises.status === 401){
                router.replace('/login');
            }
            store.commit('toggleLoading');
        });
        const practisesList = computed(() => {
            if (route.name === 'dashboard') {
                return store.getters['practises/userPractises'].slice(0, 5);
            }
            else if (route.name === 'practises') {
                return store.getters['practises/userPractises'];
            }
        });

        const activePractise = ref({
            name: "",
            start: "",
            water: null,
            farm_id: null,
            fields: [],
            plant_protection_products: []
        });

        watch(practiseId, (newValue) => {
            if (newValue) {
                activePractise.value = practisesList.value.find((practise) => practise.id === newValue)
            } else {
                activePractise.value = {
                    name: "",
                    start: "",
                    water: null,
                    farm_id: null,
                    fields: [],
                    plant_protection_products: []
                }
            }
        });
        function showProductListPage() {
            activePractise.value = {
                name: "",
                start: "",
                water: null,
                farm_id: null,
                fields: [],
                plant_protection_products: []
            }
            practiseId.value = null;
            activeComponent.value = 'practiseList';
        }
        function showDescriptionPage(id = practiseId.value) {
            activeComponent.value = 'descriptionPractise';
            practiseId.value = id;
        }

        function showCreatePage() {
            practiseId.value = null;
            activeComponent.value = 'createPractise';
            lastCreateOrEdit.value = 'create';
        }

        provide('activeComponent', activeComponent);

        const isPractisePage = computed(() => {
            return route.name === 'practises' ? true : false;
        });

        return {
            practiseId,
            activeComponent,
            practisesList,
            activePractise,
            showProductListPage,
            showDescriptionPage,
            showCreatePage,
            isPractisePage,
        }
    }
}
</script>
