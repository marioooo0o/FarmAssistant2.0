<template>
    <base-description-card
    saveIcon cancelIcon
    @cancel-clicked="$emit('show-add-edit-practise')"
    @close-description-card="$emit('close-edit-card')"
    @save-clicked="submitForm">
        <div class="flex flex-col items-center font-semibold tracking-wider">
            <h1 class="text-2xl">Środek {{product.name}}</h1>
            <form class="flex flex-col justify-center items-center" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="productQuantity" label="Ilość środka:" required 
                    v-model="productQuantity" type="number" min="0" step="0.01" :unit="unit" :error="errors['productQuantity']" />
                </base-form-control>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, computed, watch } from 'vue';
import BaseDescriptionCard from '../ui/BaseDescriptionCard.vue';
import BaseFormControl from '../ui/BaseFormControl.vue';

export default {
    components: {
        BaseDescriptionCard,
        BaseFormControl,
    },
    props: {
        modelValue: "",
        required: Boolean,
        product: {
            type: Object,
            required: true
        },
        practise: {
            type: Object,
            required: true
        },
        allProducts: {
            type: [Array, Object],
            required: true
        },
        lastCreateOrEdit:{
            type: String,
            required: true
        }
    },
    emits: ['close-edit-card', 'show-add-practise', 'show-add-edit-practise', 'update-products-quantity'],
    setup(props, {emit}) {
        const productQuantity = ref(props.practise.plant_protection_products.length > 0 && props.practise.plant_protection_products.find((product) => product.id === props.product.id)? props.practise.plant_protection_products.find((product) => product.id === props.product.id).pivot.quantity : 0);
        // const productQuantity = ref(props.practise.plant_protection_products.length > 0 && props.allProducts.find((product) => product.id === props.product.id).pivot.quantity ? props.allProducts.find((product) => product.id === props.product.id).pivot.quantity : 0);

        const errors = reactive({
            productQuantity: [],
        });

        const unit = computed(()=>{
            return props.product.unit.split('/')[0];
        });

        const saveFirstClicked = ref(false);

        function checkForm(){
            errors.productQuantity = [];
            if(props.lastCreateOrEdit === 'edit' && (productQuantity.value && productQuantity.value > 0)){
               return true;
            }
            else if(props.lastCreateOrEdit === 'create' && (productQuantity.value && productQuantity.value > 0 && productQuantity.value <= props.product.pivot.quantity)){
                return true;
            }
            if (!productQuantity.value || productQuantity.value === 0){
                errors.productQuantity.push('Ilość środka jest wymagana');
            }
            if (productQuantity.value < 0) {
                errors.productQuantity.push('Ilość środka musi być większa od 0');
            }
            if(productQuantity.value > props.product.pivot.quantity){
                errors.productQuantity.push('Ilość środka jest większa od tej posiadanej w magazynie');
            }
            return false;
        }


        function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    id: props.product.id,
                    name: props.product.name,
                    unit: props.product.unit.split('/')[0],
                    quantity: parseFloat(productQuantity.value),
                    pivot:{
                        quantity: props.product.pivot.quantity - parseFloat(productQuantity.value)
                    }
                };
                emit('update-products-quantity', formData);
            } 
        }

        return {
            productQuantity,
            errors,
            unit,
            submitForm
        }
    }
}
</script>
