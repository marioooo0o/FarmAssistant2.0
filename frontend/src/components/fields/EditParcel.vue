<template>
    <base-description-card @close-description-card="$emit('close-edit-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider">
            <h1 class="text-2xl">Działka {{parcel.name}}</h1>
            <span class="my-2 text-lg">Działka ma całkowitą powierzchnię: {{parcelArea}} ha</span>
            <form class="flex flex-col justify-center items-center"  @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="parcelArea" label="Powierzchnia działki na wybranym polu :" required 
                    v-model="parcelAreaInField" type="number" unit="ha" min="0" step="0.01"/>
                </base-form-control>
                <base-button class="mt-6 text-lg" type="submit">Zapisz</base-button>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, computed } from 'vue';
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
    emits: ['close-edit-card'],
    setup(props) {
        const parcelAreaInField = ref(props.parcel.pivot.area);
        const parcelArea = computed(()=>{
            return (props.parcel.parcel_area - props.parcel.pivot.area + Number(parcelAreaInField.value)).toFixed(2);
        });

        function submitForm(){
            const formData = {
                area: parcelAreaInField.value,
                parcel_area: parcelArea.value
            };
            console.log('dane z form', formData);
        }
        return {
            parcelArea,
            parcelAreaInField,
            submitForm
        }
    }
    
}
</script>
<style>
    
</style>