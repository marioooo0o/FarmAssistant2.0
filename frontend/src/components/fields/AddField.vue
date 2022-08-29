<template>
    <base-description-card mainIcons 
        @close-description-card="$emit('close-create-card')"
        @cancel-clicked="$emit('close-create-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Dodaj Pole</h1>
            <FieldForm
                :field="field"
                :saveIsClicked="saveIsClicked"
                @show-parcel-form="$emit('show-parcel-form', $event)"
                @submit-form="submitForm"
                />
        </div>
    </base-description-card>
</template>
<script>
import { ref } from 'vue';
import FieldForm from './FieldForm.vue';
export default {
    components: {
        FieldForm
    },
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-create-card', 'show-parcel-form'],
    setup(props) {
        const saveIsClicked = ref(false);

        function saveClicked(){
            saveIsClicked.value = true;
            console.log('submit w create');
        }

        function submitForm(formData){
            saveIsClicked.value = false;
            console.log('formData', formData);
        }

        return {
            saveIsClicked,
            saveClicked,
            submitForm
        }
    }
}
</script>