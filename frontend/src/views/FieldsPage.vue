<template>
    <Navbar />
    <FieldList :fieldsList="fieldsList" @show-description-page=showDescriptionPage />
    <FieldDescription v-if="activeComponent == 'descriptionField'" 
        :field="activeField"
        @close-description-card="showFieldListPage" 
        @show-edit-page="showEditPage" />
    <EditField v-else-if="activeComponent === 'editField'"
        :field="activeField"
        @close-edit-card="showFieldListPage" />

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
                        id: 78,
                        name: 234,
                    },
                    {
                        id: 79,
                        name: 254
                    },
                ],
                crop: {
                    id: 1,
                    src: '/src/assets/crops/tomato.png',
                    name: 'tomato'
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
                    id: 1,
                    src: '/src/assets/crops/tomato.png',
                    name: 'tomato'
                }
            },
        ];

        const activeField = computed(function(){
            return fieldsList.find((field) => field.id === fieldId.value)
        });

        function showFieldListPage(){
            activeComponent.value = 'fieldList';
        }
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
            showFieldListPage,
            showDescriptionPage,
            showEditPage
        }
    }
}
</script>
