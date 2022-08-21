<template>
    <Navbar />
    <FieldList :fieldsList="fieldsList" 
    @show-description-page=showDescriptionPage />
    <FieldDescription 
    v-if="activeComponent == 'descriptionField'"
    :field="activeField"
    @show-edit-page="showEditPage" />
    <EditField v-else-if="activeComponent === 'editField'" />

</template>
<script>
import Navbar from '../components/navbar/TheNavbar.vue';
import FieldList from '../components/fields/FieldList.vue';
import FieldDescription from '../components/fields/FieldDescription.vue';
import EditField from '../components/fields/EditField.vue';
import { ref, computed, provide } from 'vue';
export default {
    components: { Navbar, FieldList, FieldDescription, EditField },
    setup() {
        const activeComponent = ref('fieldList');

        const fieldId = ref(null);
        const fieldsList = [
            {
                id: 0,
                name: 'Pole Romana',
                area: 11.0,
                parcels: [
                    {
                        id: 1,
                        name: 234,
                    },
                    {
                        id: 2,
                        name: 254
                    },
                ],
                crop: {
                    src: '/src/assets/crops/tomato.png',
                    alt: 'tomato'
                }
            },
            {
                id: 1,
                name: 'Pole Okiego',
                area: 47.0,
                parcels: [
                    {
                        id: 4,
                        name: 224,
                    },
                    {
                        id: 3,
                        name: 21
                    },
                ],
                crop: {
                    src: '/src/assets/crops/tomato.png',
                    alt: 'tomato'
                }
            },
        ];

        const activeField = computed(function(){
            return fieldsList.find((field) => field.id === fieldId.value)
        });

        function showDescriptionPage(id){
            activeComponent.value = 'descriptionField';
            fieldId.value = id;
        }

        function showEditPage(id){
            activeComponent.value = 'editField';
        }

        provide('activeComponent', activeComponent);
        return {
            activeComponent,
            fieldsList,
            activeField,
            showDescriptionPage,
            showEditPage
        }
    }
}
</script>
