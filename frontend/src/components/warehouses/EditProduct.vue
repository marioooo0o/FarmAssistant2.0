<template>
    <base-description-card mainIcons
        formName="productForm"
        @close-description-card="$emit('close-edit-card')"
        @cancel-clicked="$emit('close-edit-card')"
    >
    <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Edytuj Produkt</h1>
            <form id="productForm" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="productName" label="Nazwa środka:"  disabled name="productName" v-model="productName" ></base-label> 
                </base-form-control>
                <base-form-control>
                    <base-label id="productQuantity" label="Ilość środka:" v-model="productQuantity" type="number" min="0" name="productQuantity" :error="errors['productQuantity']"></base-label>
                </base-form-control>
            </form>
    </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, watch, provide } from 'vue'; 
import { useStore } from 'vuex';
import { useRouter} from 'vue-router';
export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    emits: ['close-edit-card', 'submit-form'],
    setup(props, { emit }) {
        const store = useStore();
        const router = useRouter();

        const productName = ref(props.product.name ? props.product.name : "");
        const productQuantity = ref(props.product.pivot.quantity ? props.product.pivot.quantity : "");

        const errors = reactive({
            productQuantity: [],
        });

        const saveFirstClicked = ref(false);
        watch(productName, (newValue) => {
            if(saveFirstClicked.value){
                errors.productName = [];
                if(newValue === null){
                    errors.productName.push("Nazwa produktu jest wymagana");
                }
            }
        });
        function checkForm(){
            errors.productQuantity = [];
            if (productQuantity.value){
                return true;
            }
            if(!productQuantity.value){
                errors.productQuantity.push("Ilość środka jest wymagana");
            }
            return false;
        }

        provide('errors', errors);

        async function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    productId: props.product.id,
                    quantity: productQuantity.value,
                }
                store.commit('toggleLoading');
                const response = await store.dispatch('warehouses/editProduct', formData);
                if(response.status === 200){
                    emit('close-edit-card');
                }
                else if(response.status === 422){
                    errors.productQuantity = [];
                    for(let e in response.errors){
                        switch(e){
                            case 'quantity':
                                errors.productQuantity.push(...response.errors[e]);
                                break;
                        }
                    }
                }
                else if(response.status === 401){
                    store.commit('auth/setUnauth', {root: true});
                    router.replace('/login');
                }
                store.commit('toggleLoading');
            }
        }
        return{
            productName,
            productQuantity,
            errors,           
            submitForm,
        }
    }

}
</script>
