<template>
    <Navbar />
    <FieldList
        :fieldsList="fieldsList" 
        @show-description-page=showDescriptionPage
        @show-create-page="showCreatePage" />
    <FieldDescription v-if="activeComponent == 'descriptionField'" 
        :field="activeField"
        @close-description-card="showFieldListPage" 
        @show-edit-page="showEditPage" />
    <AddField v-if="activeComponent == 'createField'"
        :field="activeField"
        @close-create-card="showFieldListPage"
        @show-parcel-form="showEditParcel"
        />
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
import { ref, computed, provide, watch } from 'vue';
import { useStore } from 'vuex'
import AddField from '../components/fields/AddField.vue';
export default {
    components: { Navbar, FieldList, FieldDescription, EditField, EditParcel, AddField },
    setup() {
        const store = useStore();
        const activeComponent = ref('fieldList');

        const fieldId = ref(null);
        const fieldsList = computed(()=>{
            return store.getters['fields/userFields'];
        })

        const activeField = ref({
                field_name: "",
                field_area: null,
                crop: null,
                cadastral_parcels: [],
            });
        // const activeField = computed(function(){
        //     return fieldsList.value.find((field) => field.id === fieldId.value)
        // });
        watch(fieldId, (newValue)=> {
            console.log('new Vlaue', newValue);
            if(newValue){
                activeField.value = fieldsList.value.find((field) => field.id === newValue)
            }else{
                activeField.value = {
                field_name: "",
                field_area: null,
                crop: null,
                cadastral_parcels: [],
            }
            }
        });
        function showFieldListPage(){
            activeField.value = {
                field_name: "",
                field_area: null,
                crop: null,
                cadastral_parcels: [],
                }
            fieldId.value = null;
            activeComponent.value = 'fieldList';
        }
        function showDescriptionPage(id = fieldId.value){
            activeComponent.value = 'descriptionField';
            fieldId.value = id;
        }

        function showCreatePage(){
            fieldId.value = null;
            activeComponent.value = 'createField';
        }

        function showEditPage(){
            activeComponent.value = 'editField';
        }

        const activeParcel = ref(null);

        function updateParcelArea(formData){
            activeParcel.value.parcel_area= parseFloat(formData.parcel_area);
            activeParcel.value.pivot = {
                area: parseFloat(formData.area)
            }
            const parcelInField = activeField.value.cadastral_parcels.find((parcel) => parcel.parcel_number === activeParcel.value.parcel_number)
            if(parcelInField){
                const index = activeField.value.cadastral_parcels.findIndex((parcel) => parcel.parcel_number === activeParcel.value.parcel_number);
                activeField.value.cadastral_parcels[index].pivot = activeParcel.value.pivot;
                activeField.value.cadastral_parcels[index].parcel_area = activeParcel.value.parcel_area;
            }
            else{
                activeField.value.cadastral_parcels.push(activeParcel.value);
            }
            
            if(fieldId.value){
                showEditPage();
            }else{
                showCreatePage();
            }
            
        }
        function showEditParcel(parcel){
            activeParcel.value = parcel;
            activeComponent.value = 'editParcel';
        }

        provide('activeComponent', activeComponent);
        return {
            fieldId,
            activeComponent,
            fieldsList,
            activeField,
            showFieldListPage,
            showDescriptionPage,
            showCreatePage,
            showEditPage,
            updateParcelArea,
            showEditParcel,
            activeParcel
        }
    }
}
</script>
