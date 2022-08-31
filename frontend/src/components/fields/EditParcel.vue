<template>
    <base-description-card
    mainIcons
    @cancel-clicked="$emit('show-edit-field')"
    @close-description-card="$emit('close-edit-card')"
    @save-clicked="submitForm">
        <div class="flex flex-col items-center font-semibold tracking-wider">
            <h1 class="text-2xl">Działka {{parcel.name}}</h1>
            <span class="my-2 text-lg">Działka ma całkowitą powierzchnię: {{parcelArea}} ha</span>
            <form class="flex flex-col justify-center items-center" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="parcelArea" label="Powierzchnia działki na wybranym polu :" required 
                    v-model="parcelAreaInField" type="number" unit="ha" min="0" step="0.01" :error="errors['parcelAreaInField']"/>
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
        parcel:{
            type: Object,
        }
    },
    emits: ['close-edit-card', 'show-edit-field', 'save-parcel'],
    setup(props, {emit}) {
        
        //powierzchnia działki ewidencyjnej należącej do pola
        const parcelAreaInField = ref((("pivot" in  props.parcel) && ("area" in props.parcel.pivot)) ? props.parcel.pivot.area : 0);
        //całkowita powierzchnia działki ewidencyjnej
        const parcelArea = computed(()=>{
            if(props.parcel.parcel_area > 0){
                if((("pivot" in  props.parcel) && ("area" in props.parcel.pivot))){
                    return (props.parcel.parcel_area - props.parcel.pivot.area + Number(parcelAreaInField.value)).toFixed(2);
                }
                else{
                    return (props.parcel.parcel_area + Number(parcelAreaInField.value)).toFixed(2);
                }
            }
            else {
                return parcelAreaInField.value;
            }
        });
        
        const errors = reactive({
            parcelAreaInField: [],
        });

        const saveFirstClicked = ref(false);

        watch(parcelAreaInField, (newValue, oldValue) => {
            if(saveFirstClicked.value){
                errors.parcelAreaInField = [];

                if(newValue === null){
                    errors.parcelAreaInField.push('Powierzchnia działki jest wymagana');
                }
            }
        }); 

        function checkForm(){
            errors.parcelAreaInField = [];
            if(parcelAreaInField.value && parcelAreaInField.value !== "0"){
                return true;
            }
            else{
                errors.parcelAreaInField.push('Powierzchnia działki jest wymagana');
                return false;
            }
        }

        function submitForm(){
            console.log('wbiło do submit');
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                area: parseFloat(parcelAreaInField.value),
                parcel_area: parseFloat(parcelArea.value)
                };
                console.log('dane z form', formData);
                emit('save-parcel', formData);
            }
            
        }
        return {
            parcelArea,
            parcelAreaInField,
            errors,
            submitForm
        }
    }
    
}
</script>
<style>
    
</style>