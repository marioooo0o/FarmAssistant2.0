<template>
    <base-description-card saveIcon cancelIcon
        formName="practiseForm" 
        @close-description-card="$emit('close-edit-card')"
        @cancel-clicked="$emit('close-edit-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Edytuj Zabieg</h1>
            <form id="practiseForm" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="practiseName" label="Nazwa zabiegu:" required v-model.trim="practiseName" type="text" name="practiseName"
                        :error="errors['practiseName']" />
                </base-form-control>
                <base-form-control>
                    <base-label date id="practiseDate" label="Data wykonania zabiegu:" required v-model="practiseDate" type="date" name="practiseDate"
                        :error="errors['practiseDate']" />
                </base-form-control>
                <base-form-control>
                    <ProductSearchInput search id="practiseProdcts" label="Środki ochrony roślin:" required placeholder="wyszukaj produkt:"
                        :searchData="allProducts" :actualData="practiseProducts" 
                        searchKey="name"
                        :error="errors['practiseProducts']"
                        @show-product-quantity-form="showProductQuantityForm"
                        @update-product-list="updateProductList"
                    />
                </base-form-control>
                <base-form-control>
                    <FieldSearchInput search id="practiseProdcts" label="Pola:" required placeholder="wyszukaj pole:"
                        :searchData="allFields" :actualData="practiseFields" 
                        searchKey="field_name"
                        :error="errors['practiseFields']"
                        @add-field-to-list="addFieldToList"
                        @delete-field-from-list="deleteFieldFromList"/>
                </base-form-control>
                <base-form-control>
                    <base-label id="practiseWater" label="Ilość wody:" 
                        required v-model="practiseWater" type="number" 
                        name="practiseWater"
                        min="0"
                        unit="l"     
                    :error="errors['practiseWater']" />
                </base-form-control>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, computed, watch, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import ProductSearchInput from './ProductSearchInput.vue';
import FieldSearchInput from './FieldSearchInput.vue';
export default {
    components: {
        ProductSearchInput,
        FieldSearchInput
    },
    props: {
        practise: {
            type: Object, 
            required: true
        }
    },
    emits: ['close-edit-card', 'show-product-quantity-form', 'set-practise-attr'],
    setup(props, { emit }) {
        const store = useStore();
        const router = useRouter();

        onBeforeMount(async() => {
            store.commit('toggleLoading');
            const resProducts = await store.dispatch('warehouses/loadAllWarehouseProducts');
            if (resProducts && resProducts.status === 401) {
                router.replace('/login');
            }
            const resFields = await store.dispatch('fields/loadAllFields');
            if(resFields && resFields.status === 401){
                router.replace('/login');
            }
            store.commit('toggleLoading');
        })

        const practiseName = ref(props.practise.name ? props.practise.name : "");
        const practiseDate = ref(props.practise.start ? props.practise.start : "");
        const practiseProducts = ref(props.practise.plant_protection_products ? props.practise.plant_protection_products : []);
        const practiseFields = ref(props.practise.fields ? props.practise.fields : []);
        const practiseWater = ref(props.practise.water ? props.practise.water : 0);
        const selectedProduct = ref(null);

        const allProducts = computed(() => {
            return store.getters['warehouses/allWarehouseProducts'];
        });

        const allFields = computed(() => {
            return store.getters['fields/allUserFields'];
        })

        function showProductQuantityForm($event){
            const formData = {
                practiseName: practiseName.value,
                practiseDate: practiseDate.value,
                practiseProducts: practiseProducts.value,
                practiseFields: practiseFields.value,
                practiseWater: practiseWater.value
            }
            emit('set-practise-attr', formData);
            emit('show-product-quantity-form', $event)
        }

        function UpdateProduct(product) {
            selectedProduct.value = product;
        }

        function addFieldToList(field){
            practiseFields.value.push(field);
        }

        function updateProductList(productList){
            practiseProducts.value = productList;
        }

        function deleteFieldFromList(fields){
            practiseFields.value = fields;
        }
        const errors = reactive({
            practiseName: [],
            practiseDate: [],
            practiseProducts: [],
            practiseFields: [],
            practiseWater: []
        });

        const saveFirstClicked = ref(false);

        watch(selectedProduct, (newValue) => {
            if (saveFirstClicked.value) {
                errors.practiseName = [];
                if (newValue === null) {
                    errors.practiseName.push("Nazwa produktu jest wymagana");
                }
            }
        });

        function checkForm() {
            errors.practiseName = [];
            errors.practiseDate = [];
            errors.practiseProducts = [];
            errors.practiseFields = [];
            errors.practiseWater = [];

            if (practiseName.value && practiseDate.value && practiseFields.value.length !== 0 && practiseProducts.value.length !== 0 && practiseWater.value) {
                return true;
            }

            if(!practiseName.value){
                errors.practiseName.push("Nazwa zabiegu jest wymagana");
            }
            if(!practiseDate.value){
                errors.practiseDate.push("Data zabiegu jest wymagana");
            }
            if(practiseProducts.value.length === 0){
                errors.practiseProducts.push("Zabieg musi zawierać środek");
            }
            if(practiseFields.value.length === 0){
                errors.practiseFields.push("Zabieg musi mieć przypisane pola");
            }
            if(!practiseWater.value){
                errors.practiseWater.push("Zabieg musi zawierać wodę");
            }
            if(practiseWater.value <= 0){
                errors.practiseWater.push("Ilość wody musi być większa od 0")
            }
            return false;
        }

        async function submitForm() {
            if (!saveFirstClicked.value) saveFirstClicked.value = true;
            if (checkForm()) {
                const formData = {
                    practiseId: props.practise.id,
                    name: practiseName.value,
                    water: practiseWater.value,
                    start_date: practiseDate.value,
                    fields: practiseFields.value.map((field) => ({"id": field.id})),
                    products: practiseProducts.value.map((product) => ({"id": product.id, "quantity": product.pivot.quantity})),
                }
                console.log('formData', formData);
                store.commit('toggleLoading');
                const response = await store.dispatch('practises/editPractise', formData);
                console.log('res', response);
                if (response.status === 200) {
                    store.commit('response/setResponse', {
                        status: true,
                        message: 'Zabieg edytowany pomyślnie!'
                    }, {root: true});
                    emit('close-edit-card');
                }
                else if (response.status === 422) {
                    console.log('res2', response);
                    errors.practiseName = [];
                    errors.practiseDate = [];
                    errors.practiseFields = [];
                    errors.practiseProducts = [];
                    errors.practiseWater = [];
                    for (let e in response.errors) {
                        switch (e) {
                            case 'name':
                                errors.practiseName.push(...response.errors[e]);
                                break;
                            case 'start_date':
                                errors.practiseDate.push(...response.errors[e]);
                                break;
                            case 'products':
                                const result = response.errors.products.some(product => !product.quantity ? true : false )
                                ? response.errors.products
                                : response.errors.products.map((error) => error.quantity);
                                console.log('maks', result);
                                errors.practiseProducts.push(...result);
                                break;
                            case 'fields':
                                errors.practiseFields.push(...response.errors[e]);
                                break;
                            case 'water':
                                errors.practiseWater.push(...response.errors[e]);
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
            practiseDate,
            practiseProducts,
            practiseFields,
            practiseWater,
            allProducts,
            allFields,
            showProductQuantityForm,
            UpdateProduct,
            addFieldToList,
            updateProductList,
            deleteFieldFromList,
            submitForm,
            errors
        }
    }
}
</script>