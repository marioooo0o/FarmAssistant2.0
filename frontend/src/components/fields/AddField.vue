<template>
        <base-description-card saveIcon cancelIcon
        @close-description-card="$emit('close-create-card')"
        @cancel-clicked="$emit('close-create-card')"
        @save-clicked="saveClicked">
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Dodaj Pole</h1>
            <FieldForm
                :field="field"
                :saveIsClicked="saveIsClicked"
                typeForm="add"
                @show-parcel-form="$emit('show-parcel-form', $event)"
                @set-field-attr="$emit('set-field-attr', $event)"
                @submit-form="submitForm"
                />
        </div>
        </base-description-card>
</template>
<script>
import { ref, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
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
    emits: ['close-create-card', 'show-parcel-form', 'set-field-attr', 'saved-successfully'],
    setup(props, {emit}) {
        const store = useStore();

        const saveIsClicked = ref(false);

        function saveClicked(){
            saveIsClicked.value = true;
            setTimeout(() => {
                saveIsClicked.value = false;
            }, 2000);
        }

        async function submitForm(formData){
            saveIsClicked.value = false;   
            if(formData.status === 201){
                emit('saved-successfully');
            }
        }

        return {
            saveIsClicked,
            saveClicked,
            submitForm
        }
    }
}
</script>