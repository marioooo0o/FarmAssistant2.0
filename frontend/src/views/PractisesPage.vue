<template>
    <Navbar v-if="isPractisePage"/>
    <PractiseList
        :practisesList="practisesList"
        @show-description-page=showDescriptionPage
        @show-create-page="showCreatePage" />
    <AddPractise v-if="activeComponent == 'createPractise'"
        :practise="activePractise"
        :allProducts="allProducts"
        @close-add-card="showProductListPage"
        @saved-successfully=""
        @show-product-quantity-form="showEditQuantity"
        @set-practise-attr="updatePractiseAttr"/>
    <EditProductQuantity v-else-if="activeComponent == 'editProductQuantity'"
        :product="activeProduct"
        :practise="activePractise"
        :allProducts="allProducts"
        :lastCreateOrEdit="lastCreateOrEdit"
        @show-add-practise="showCreatePage"
        @close-edit-card="showProductListPage"
        @update-products-quantity="updateQuantity"
        @show-add-edit-practise="showCreateOrEditPage"/>
    <PractiseDescription v-else-if="activeComponent == 'descriptionPractise'"
        :practise="activePractise"
        @show-edit-page="showEditPage"
        @close-description-card="showProductListPage" />
    <EditPractise v-else-if="activeComponent === 'editPractise'"
        :practise="activePractise"
        @close-edit-card="showProductListPage"
        @show-product-quantity-form="showEditQuantity"
        @show-add-edit-practise="showCreateOrEditPage"
        @set-practise-attr="updatePractiseAttr"/>
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
import EditPractise from '../components/practises/EditPractise.vue'
export default {
    components: { Navbar, PractiseList, PractiseDescription, AddPractise, EditProductQuantity, EditPractise },
    setup(props) {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();

        const activeComponent = ref('practiseList');
        const lastCreateOrEdit = ref('');

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

        const allProducts = computed(() => {
            return store.getters['warehouses/allWarehouseProducts'];
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
            name: "",
            pivot: {
                quantity: 0
            }
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
            activePractise.value.name = formData.practiseName,
            activePractise.value.start = formData.practiseDate,
            activePractise.value.water = formData.practiseWater,
            activePractise.value.fields = formData.practiseFields,
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

        function showEditPage(){
            activeComponent.value = 'editPractise';
            lastCreateOrEdit.value = 'edit';
        }

        function showCreateOrEditPage(){
            if(lastCreateOrEdit.value == 'create'){
                showCreatePage();
            }
            else{
                showEditPage();
            }
        }

        function showEditQuantity(product){
            activeProduct.value = product;
            activeComponent.value = 'editProductQuantity'
        }

        function updateQuantity(formData){
            const productData = {
                id: formData.id,
                name: formData.name,
                unit: formData.unit,
                pivot:{
                    quantity: formData.quantity
                }
            }
            activeProduct.value.pivot.quantity = formData.pivot.quantity;
            const productInPractise = activePractise.value.plant_protection_products.find((product) => product.id === activeProduct.value.id);
            console.log('product in practise', productInPractise);
            
            if(productInPractise){
                const index = activePractise.value.plant_protection_products.findIndex((product) => product.id === activeProduct.value.id)
                activePractise.value.plant_protection_products[index].pivot.quantity = formData.quantity;
            }else{
                activePractise.value.plant_protection_products.push(productData);
            }
            console.log('practiseId', practiseId.value);
            if(practiseId.value){
                showEditPage();
            }
            else{
                showCreatePage();
            }
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
            allProducts,
            lastCreateOrEdit,
            updatePractiseAttr,
            showProductListPage,
            showDescriptionPage,
            showCreatePage,
            showEditPage,
            showCreateOrEditPage,
            showEditQuantity,
            updateQuantity,
            isPractisePage,
        }
    }
}
</script>
