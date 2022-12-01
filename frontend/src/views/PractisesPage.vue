<template>
    <Navbar v-if="isPractisePage"/>
    <PractiseList
        :practisesList="practisesList"
        @show-description-page=showDescriptionPage
        @show-create-page="showCreatePage" />
    <AddPractise v-if="activeComponent == 'createPractise'"
        :practise="activePractise"
        @close-add-card="showProductListPage"
        @saved-successfully=""
        @show-product-quantity-form="showEditQuantity"
        @set-practise-attr="updatePractiseAttr"/>
    <EditProductQuantity v-else-if="activeComponent == 'editProductQuantity'"
        :product="activeProduct"
        @show-add-practise="showCreatePage"
        @close-edit-card="showProductListPage"
        @update-products-quantity="updateQuantity"/>
    <!-- <PractiseDescription v-if="activeComponent == 'descriptionPractise'"
        :practise="activePractise"
        @close-description-card="showProductListPage" /> -->
</template>
<script>
import { ref, computed, provide, watch, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue';
import PractiseList from '../components/practises/PractiseList.vue';
import PractiseDescription from '../components/practises/PractiseDescription.vue';
import AddPractise from '../components/practises/AddPractise.vue';
import EditProductQuantity from '../components/practises/EditProductQuantity.vue';
export default {
    components: { Navbar, PractiseList, PractiseDescription, AddPractise, EditProductQuantity },
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

        const activeProduct = ref({
            id: null,
            name: ""
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

        function updatePractiseAttr(formData){
            console.log('form data w page', formData);
            activePractise.value.name = formData.practiseName,
            activePractise.value.start = formData.practiseDate,
            activePractise.value.water = formData.practiseWater,
            activePractise.value.fields = formData.practiseFields.value,
            activePractise.value.plant_protection_products = formData.practiseProducts;
        }
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

        function showEditQuantity(product){
            activeProduct.value = product;
            activeComponent.value = 'editProductQuantity'
        }

        function updateQuantity(formData){
            const productData = {
                id: formData.id,
                name: formData.name,
                quantity: formData.quantity,
                unit: formData.unit,
                pivot:{
                    quantity: formData.pivot.quantity
                }
            }
            console.log('formik', formData);
            activeProduct.value = productData;
            const productInPractise = activePractise.value.plant_protection_products.find((product) => product.id === activeProduct.value.id);
            console.log('product in practise', productInPractise);
            
            if(productInPractise){
                const index = activePractise.value.plant_protection_products.findIndex((product) => product.id === activeProduct.value.id)
                activePractise.value.plant_protection_products[index].quantity = productData.quantity;
            }else{
                activePractise.value.plant_protection_products.push(productData);
            }

            showCreatePage();
            // productInPractise = activePractise.value.plant_protection_products
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
            activeProduct,
            updatePractiseAttr,
            showProductListPage,
            showDescriptionPage,
            showCreatePage,
            showEditQuantity,
            updateQuantity,
            isPractisePage,
        }
    }
}
</script>
