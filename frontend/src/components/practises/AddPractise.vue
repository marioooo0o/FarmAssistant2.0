<template>
    <base-description-card mainIcons formName="practiseForm" 
        @close-description-card="$emit('close-add-card')"
        @cancel-clicked="$emit('close-add-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Dodaj Produkt</h1>
            <form id="productForm" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="practiseName" label="Nazwa zabiegu:" required v-model.trim="practiseName" type="text" name="fieldName"
                        :error="errors['fieldName']" />
                </base-form-control>
                <base-form-control>
                    <ParcelSearchInput search id="practiseProducts" label="Środki ochrony roślin:" required placeholder="wyszukaj środek:"
                        :searchData="allProducts" :actualData="practiseProducts" searchKey="parcel_number" :error="errors['practiseProducts']"
                         />
                </base-form-control>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

import SearchFormControl from '../ui/SearchFormControl.vue';
export default {
    components: {
        SearchFormControl
    },
    emits: ['close-add-card'],
    setup(props, { emit }) {
        const store = useStore();
        const router = useRouter();

        const practiseName = ref("");
        const practiseProducts = ref([]);


        const selectedProduct = ref(null);

        const allProducts = computed(() => {
            return store.getters['warehouses/allPlantProtectionProducts'];
        });

        

        function UpdateProduct(product) {
            selectedProduct.value = product;
        }

        const errors = reactive({
            productName: [],
            practiseProducts: [],
        });

        const saveFirstClicked = ref(false);

        watch(selectedProduct, (newValue) => {
            if (saveFirstClicked.value) {
                errors.productName = [];
                if (newValue === null) {
                    errors.productName.push("Nazwa produktu jest wymagana");
                }
            }
        });
        

        function checkForm() {
            errors.productName = [];
            if (selectedProduct.value) {
                return true;
            }

            if (!selectedProduct.value) {
                errors.productName.push("Nazwa produktu jest wymagana");
            }
            return false;
        }

        async function submitForm() {
            if (!saveFirstClicked.value) saveFirstClicked.value = true;
            if (checkForm()) {
                const formData = {
                    id: selectedProduct.value.id,
                    quantity: productQuantity.value,
                }
                store.commit('toggleLoading');
                const response = await store.dispatch('warehouses/addProduct', formData);
                if (response.status === 201) {
                    emit('close-add-card');
                }
                else if (response.status === 422) {
                    errors.productName = [];
                    errors.productQuantity = [];
                    for (let e in response.errors) {
                        switch (e) {
                            case 'ppp_id':
                                errors.productName.push(...response.errors[e]);
                                break;
                            case 'quantity':
                                errors.productQuantity.push(...response.errors[e]);
                                break;
                        }
                    }
                }
                else if (response.status === 401) {
                    router.replace('/login');
                }
                store.commit('toggleLoading');
            }
        }
        return {
            practiseName,
            practiseProducts,
            allProducts,
            UpdateProduct,
            submitForm,
            errors
        }

    }
}
</script>
