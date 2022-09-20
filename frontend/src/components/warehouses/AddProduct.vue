<template>
    <base-description-card mainIcons
        formName="productForm"
        @close-description-card="$emit('close-add-card')"
        @cancel-clicked="$emit('close-add-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Dodaj Produkt</h1>
            <form id="productForm" @submit.prevent="submitForm">
                <base-form-control>
                    <SearchFormControl id="productName" label="Nazwa środka:" required placeholder="wyszukaj środek:" search :searchData="allProducts" name="productName" :error="errors['productName']"
                        :actualData="selectedProduct"
                        @update-search-list="UpdateProduct"/>
                </base-form-control>
                <base-form-control>
                    <base-label id="productQuantity" label="Ilość środka:" v-model="productQuantity" type="number" min="0" name="productQuantity" :error="errors['productQuantity']"></base-label>
                </base-form-control>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter} from 'vue-router';
import SearchFormControl from '../ui/SearchFormControl.vue';
export default {
    components: {
        SearchFormControl
    },
    emits: ['close-add-card'],
    setup(props, { emit }){
        const store = useStore();
        const router = useRouter();

        const selectedProduct = ref(null);

        const allProducts = computed(() => {
            return store.getters['warehouses/allPlantProtectionProducts'];
        });

        const productQuantity = ref("");

        function UpdateProduct(product){
            selectedProduct.value = product;
        }

        const errors = reactive({
            productName: [],
            productQuantity: [],
        });

        const saveFirstClicked = ref(false);

        watch(selectedProduct, (newValue) => {
            if(saveFirstClicked.value){
                errors.productName = [];
                if(newValue === null){
                    errors.productName.push("Nazwa produktu jest wymagana");
                }
            }
        });
        watch(productQuantity, (newValue) => {
            if(saveFirstClicked.value){
                errors.productQuantity = [];
                if(newValue === ""){
                    errors.productQuantity.push("Nazwa produktu jest wymagana");
                }
            }
        });

        function checkForm(){
            errors.productName = [];
            errors.productQuantity = [];
            if (selectedProduct.value && productQuantity.value){
                return true;
            }

            if(!selectedProduct.value){
                errors.productName.push("Nazwa produktu jest wymagana");
            }
            if(!productQuantity.value){
                errors.productQuantity.push("Ilość środka jest wymagana");
            }
            return false;
        }

        async function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    id: selectedProduct.value.id,
                    quantity: productQuantity.value,
                }
                store.commit('toggleLoading');
                const response = await store.dispatch('warehouses/addProduct', formData);
                if(response.status === 201){
                    emit('close-add-card');
                }
                else if(response.status === 422){
                    errors.productName = [];
                    errors.productQuantity = [];
                    for(let e in response.errors){
                        switch(e){
                            case 'ppp_id':
                                errors.productName.push(...response.errors[e]);
                                break;
                            case 'quantity':
                                errors.productQuantity.push(...response.errors[e]);
                                break;
                        }
                    }
                }
                else if(response.status === 401){
                    router.replace('/login');
                }
                store.commit('toggleLoading');
            }
        }
        return {
            selectedProduct,
            allProducts,
            productQuantity,
            UpdateProduct,
            submitForm,
            errors
        }

    }
}
</script>
