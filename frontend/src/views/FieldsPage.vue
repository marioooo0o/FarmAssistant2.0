<template>
    <Navbar v-if="isFieldPage"/>
    <FieldList
        :fieldsList="fieldsList" 
        @show-description-page=showDescriptionPage
        @show-create-page="showCreatePage" />
    <FieldDescription v-if="activeComponent == 'descriptionField'" 
        :field="activeField"
        @close-description-card="showFieldListPage" 
        @show-edit-page="showEditPage" />
    <AddField v-else-if="activeComponent == 'createField'"
        :field="activeField"
        @close-create-card="showFieldListPage"
        @show-parcel-form="showEditParcel"
        @set-field-attr="updateFieldAttr"
        />
    <EditField v-else-if="activeComponent === 'editField'"
        :field="activeField"
        @close-edit-card="showFieldListPage"
        @show-description-page="showDescriptionPage"
        @show-parcel-form="showEditParcel" />
    <EditParcel v-else-if="activeComponent === 'editParcel'"
        :parcel="activeParcel"
        @close-edit-card="showFieldListPage"
        @show-add-edit-field="showCreateOrEditPage"
        @save-parcel="updateParcelArea" />
    

</template>
<script>
import { ref, computed, provide, watch, onBeforeMount, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue';
import FieldList from '../components/fields/FieldList.vue';
import FieldDescription from '../components/fields/FieldDescription.vue';
import EditField from '../components/fields/EditField.vue';
import EditParcel from '../components/fields/EditParcel.vue';

import AddField from '../components/fields/AddField.vue';
import ResponseModal from '../components/ui/ResponseModal.vue';
export default {
    components: { Navbar, FieldList, FieldDescription, EditField, EditParcel, AddField, ResponseModal },
    setup() {
        const store = useStore(); 
        const route = useRoute();
        const router = useRouter();

        const activeComponent = ref('fieldList');
        const lastCreateOrEdit = ref(null);

        const fieldId = ref(null);
        onBeforeMount(async() => {
                store.commit('toggleLoading');
                const responseUserProfile = await store.dispatch('auth/loadUserProfile');
                if(responseUserProfile && responseUserProfile.status === 401){
                    router.replace('/login');
                }
                const responseFields = await store.dispatch('fields/loadFields');
                if(responseFields && responseFields.status === 401){
                    router.replace('/login');
                }
                store.commit('toggleLoading');
            
        });
        const fieldsList = computed(()=>{
            if(route.name === 'dashboard'){
                return store.getters['fields/userFields'].slice(0,5);
            }
            else if(route.name === 'fields'){
                return store.getters['fields/userFields'];
            }
            
        });

        const activeField = ref({
                field_name: "",
                field_area: null,
                crop: null,
                cadastral_parcels: [],
            });

        watch(fieldId, (newValue)=> {
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

        function updateFieldAttr(formData){
            activeField.value.field_name = formData.field_name;
            activeField.value.crop = formData.crop;
            activeField.value.cadastral_parcels = formData.cadastral_parcels;
        }
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
            lastCreateOrEdit.value = 'create';
        }

        function showEditPage(){
            activeComponent.value = 'editField';
            lastCreateOrEdit.value = 'edit';
        }

        function showCreateOrEditPage(){
            if(lastCreateOrEdit.value == 'create'){
                showCreatePage();
            }
            else{
                showEditPage();
            }
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

        const isFieldPage = computed(() => {
            return route.name === 'fields' ? true : false;
        });

        return {
            fieldId,
            activeComponent,
            fieldsList,
            activeField,
            showFieldListPage,
            showDescriptionPage,
            showCreatePage,
            showEditPage,
            showCreateOrEditPage,
            updateParcelArea,
            showEditParcel,
            updateFieldAttr,
            activeParcel,
            isFieldPage,
        }
    }
}
</script>
