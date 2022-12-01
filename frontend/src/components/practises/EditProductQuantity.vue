<template>
    <base-description-card
    mainIcons
    @cancel-clicked="$emit('show-add-practise')"
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
        },
    },
    emits: ['close-edit-card', 'show-add-practise', 'update-products-quantity'],
    setup(props, {emit}) {
        const productQuantity = ref(props.product.quantity ? props.product.quantity : 0);

        const errors = reactive({
            productQuantity: [],
        });

        const unit = computed(()=>{
            return props.product.unit.split('/')[0];
        });

        const saveFirstClicked = ref(false);

        function checkForm(){
            errors.productQuantity = [];
            if(productQuantity.value && productQuantity.value > 0 && productQuantity.value <= props.product.pivot.quantity){
                return true;
            }
            else if (!productQuantity.value || productQuantity.value === 0){
                errors.productQuantity.push('Ilość środka jest wymagana');
            }
            else if (productQuantity.value < 0) {
                errors.productQuantity.push('Ilość środka musi być większa od 0');
            }
            else if(productQuantity.value > props.product.pivot.quantity){
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
                        quantity: props.product.pivot.quantity
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
