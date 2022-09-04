<template>
    <Navbar />
    <ProductsList :productsList="productsList"
        @show-create-page="showCreatePage"
        @edit-product="showEditPage" />
    <EditProduct v-if="activeComponent === 'editProduct'"
        :product="activeProduct" />
</template>
<script>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';
import Navbar from '../components/navbar/TheNavbar.vue'
import ProductsList from '../components/warehouses/ProductsList.vue';
import EditProduct from '../components/warehouses/EditProduct.vue';
export default {
    components: { Navbar, ProductsList, EditProduct },
    setup(props) {
        const store = useStore();
        const activeComponent = ref('productsList');

        const productId = ref(null);
        const activeProduct = ref(null);
        const productsList = computed(() => {
            return store.getters['warehouses/warehouseProducts']
        });

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
            showCreatePage,
            showEditPage
        }
    }
}
</script>
