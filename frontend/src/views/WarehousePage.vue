<template>
    <Navbar />
    <ProductsList :productsList="productsList"
        @show-create-page="showCreatePage"
        @edit-product="showEditPage" />
    <AddProduct v-if="activeComponent === 'addProduct'"
        @close-add-card="showProductsListPage"/>
    <EditProduct v-if="activeComponent === 'editProduct'"
        :product="activeProduct"
        @close-edit-card="showProductsListPage" />
</template>
<script>
import { ref, computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue'
import ProductsList from '../components/warehouses/ProductsList.vue';
import EditProduct from '../components/warehouses/EditProduct.vue';
import AddProduct from '../components/warehouses/AddProduct.vue';
export default {
    components: { Navbar, ProductsList, EditProduct, AddProduct },
    setup(props) {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        
        const activeComponent = ref('productsList');

        const productId = ref(null);
        const activeProduct = ref({
            id: null,
            name: "",
            pivot:{
                quantity: null
            }
        });

        onBeforeMount(async() => {
            store.commit('toggleLoading');
            const responseUserProfile = await store.dispatch('auth/loadUserProfile');
            console.log('resuserprofile warehouse', responseUserProfile);
            if(responseUserProfile && responseUserProfile.status === 401){
                    router.replace('/login');
            }
            const responseWarehouse = await store.dispatch('warehouses/loadWarehouse');
            if(responseWarehouse && responseWarehouse.status === 401){
                    router.replace('/login');
            }
            const responseAllProducts = await store.dispatch('warehouses/loadAllProducts');
            if(responseAllProducts && responseAllProducts.status === 401){
                    router.replace('/login');
            } 
            store.commit('toggleLoading');
        })

        const productsList = computed(() => {
            return store.getters['warehouses/warehouseProducts'];
        });

        function showProductsListPage(){
            productId.value = null;
            activeProduct.value = {
                id: null,
                name: "",
                pivot:{
                    quantity: null
                }
            }
            activeComponent.value = 'productsList';
        }
        function showCreatePage(){
            productId.value = null;
            activeComponent.value = 'addProduct';
        }

        function showEditPage(product){
            activeProduct.value = product;
            activeComponent.value = 'editProduct'
        }

        return {
            activeComponent,
            productId,
            activeProduct,
            productsList,
            showProductsListPage,
            showCreatePage,
            showEditPage
        }
    }
}
</script>
