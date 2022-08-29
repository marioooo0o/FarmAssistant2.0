<template>
    <Navbar />
    <FieldList :fieldsList="fieldsList" @show-description-page=showDescriptionPage />
    <FieldDescription v-if="activeComponent == 'descriptionField'" 
        :field="activeField"
        @close-description-card="showFieldListPage" 
        @show-edit-page="showEditPage" />
    <EditField v-else-if="activeComponent === 'editField'"
        :field="activeField"
        @close-edit-card="showFieldListPage"
        @show-description-page="showDescriptionPage"
        @show-parcel-form="showEditParcel" />
    <EditParcel v-else-if="activeComponent === 'editParcel'"
        :parcel="activeParcel"
        @close-edit-card="showFieldListPage"
        @show-edit-field="showEditPage"
        @save-parcel="updateParcelArea" />

</template>
<script>
import Navbar from '../components/navbar/TheNavbar.vue';
import FieldList from '../components/fields/FieldList.vue';
import FieldDescription from '../components/fields/FieldDescription.vue';
import EditField from '../components/fields/EditField.vue';
import EditParcel from '../components/fields/EditParcel.vue';
import { ref, computed, provide } from 'vue';
import { useStore } from 'vuex'
export default {
    components: { Navbar, FieldList, FieldDescription, EditField, EditParcel },
    setup() {
        const store = useStore();
        const activeComponent = ref('fieldList');

        const fieldId = ref(null);
        const fieldsList = computed(()=>{
            return store.getters['fields/userFields'];
        })

        const activeField = computed(function(){
            return fieldsList.value.find((field) => field.id === fieldId.value)
        });

        function showFieldListPage(){
            activeComponent.value = 'fieldList';
        }
        function showDescriptionPage(id = fieldId.value){
            activeComponent.value = 'descriptionField';
            fieldId.value = id;
        }

        function showEditPage(){
            activeComponent.value = 'editField';
        }

        const activeParcel = ref(null);
        function updateParcelArea(formData){
            console.log('parcelArea', parcelArea.value, typeof parcelArea.value);
            activeParcel.value.parcel_area= parseInt(formData.parcel_area);
            activeParcel.value.pivot = {
                area: parseInt(formData.area)
            }
            activeField.value.cadastral_parcels.push(activeParcel.value)
            // .area = parseInt(formData.area);
            // activeParcel.value.pivot.area = parseInt(formData.area);
            showEditPage();
        }
        function showEditParcel(parcel){
            activeParcel.value = parcel;
            activeComponent.value = 'editParcel';
        }

        provide('activeComponent', activeComponent);
        return {
            activeComponent,
            fieldsList,
            activeField,
            showFieldListPage,
            showDescriptionPage,
            showEditPage,
            updateParcelArea,
            showEditParcel,
            activeParcel
        }
    }
}
</script>
