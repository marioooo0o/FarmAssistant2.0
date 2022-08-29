<template>
    <base-description-card mainIcons
    @close-description-card="$emit('close-edit-card')"
    @cancel-clicked="$emit('show-description-page')"
    @save-clicked="saveClicked">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Edytuj Pole</h1>
            <FieldForm 
                :field="field"
                :saveIsClicked="saveIsClicked"
                @show-parcel-form="$emit('show-parcel-form', $event)"
                @submit-form="submitForm"/>
        </div>
    </base-description-card>
</template>

<script>
import { ref } from 'vue';
import BaseDescriptionCard from '../ui/BaseDescriptionCard.vue';
import BaseFormControl from '../ui/BaseFormControl.vue';
import SearchFormControl from '../ui/SearchFormControl.vue';
import EditParcel from './EditParcel.vue';
import ParcelSearchInput from './ParcelSearchInput.vue';
import FieldForm from './FieldForm.vue';
export default {
    components: { BaseDescriptionCard, BaseFormControl, BaseFormControl, SearchFormControl, EditParcel, ParcelSearchInput, FieldForm},
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-edit-card', 'show-parcel-form', 'show-description-page'],
    setup(props) {
        const field = ref(props.field);
        
        const saveIsClicked = ref(false);

        function saveClicked(){
            saveIsClicked.value = true;
            console.log('submit w edit');
        }

        function submitForm(formData){
            saveIsClicked.value = false;
            console.log('formData', formData);
        }
        return{
            field,
            saveIsClicked,
            saveClicked,
            submitForm

        }
    }
}
</script>
