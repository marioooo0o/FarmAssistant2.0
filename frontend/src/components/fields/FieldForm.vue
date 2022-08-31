<template>
    <form @submit.prevent="submitForm">
        <base-form-control>
            <base-label id="fieldName" label="Nazwa Pola:" required v-model="fieldName" type="text" name="fieldName" :error="errors['fieldName']" />
        </base-form-control>
        <base-form-control>
            <base-label id="fieldArea" label="Powierzchnia:" required v-model="fieldArea" type="number" unit="ha" disabled />
        </base-form-control>
        <base-form-control>
            <SearchFormControl search id="fieldCrop" label="Uprawa:" required placeholder="wyszukaj uprawę:" name="crop"
                :searchData="crops" :actualData="fieldCrop" 
                :error="errors['fieldCrop']"
                @update-search-list="updateCrop" />
        </base-form-control>
        <base-form-control>
            <ParcelSearchInput search id="fieldParcels" label="Działki:" required placeholder="wyszukaj działkę:"
                :searchData="parcels" :actualData="fieldParcels"
                searchKey="parcel_number"
                :error="errors['fieldParcels']"
                @show-parcel-form="$emit('show-parcel-form', $event)"
                @update-parcel-list="updateParcelList" />
        </base-form-control>
    </form>
</template>
<script>
import { ref, reactive, computed, watch, provide } from 'vue';
import { useStore } from 'vuex';
import SearchFormControl from '../ui/SearchFormControl.vue';
import ParcelSearchInput from './ParcelSearchInput.vue';
export default {
    components: { 
        SearchFormControl, 
        ParcelSearchInput },
    props:{
        field:{
            type: Object,
            required: false,
            default:{
                field_name : "",
                field_area: null,
                cadastral_parcels: null,
                crop: null
            }
        },
        saveIsClicked:{
            type: Boolean,
            default: false,
        }
    },
    emits: ['show-parcel-form', 'submit-form'],
    setup(props, {emit}){
        const store = useStore()

        const fieldName = ref(props.field.field_name ? props.field.field_name : "");
        const requiredFieldNameLength = ref(5);
            

        const fieldParcels = ref(props.field.cadastral_parcels? props.field.cadastral_parcels : null);

        const fieldArea = computed(()=>{
            if(fieldParcels.value){
                return fieldParcels.value.reduce((acc, item) => acc + (item.pivot.area ? item.pivot.area : 0), 0)
            }
            else{
                return null;
            }
            
        });

        const fieldCrop = ref(props.field.crop ? props.field.crop : null);

        function updateCrop(crop){
            console.log('crop wynois', crop);
            fieldCrop.value = crop
        }

        const crops = computed(()=>{
            return store.getters['fields/allCrops'];
        });

        const parcels = computed(()=>{
            return store.getters['fields/allParcels'];
        });

        function updateParcelList(parcelList){
            console.log('updateParcelList', parcelList);
            fieldParcels.value = parcelList;
        }
        const errors = reactive({
            fieldName: [],
            fieldCrop: [],
            fieldParcels: [],
        });

        const saveFirstClicked = ref(false);
        watch(fieldName, (newValue)=>{
            console.log('wbiło47?', newValue, saveFirstClicked.value);
            if(saveFirstClicked.value){
                errors.fieldName = [];
                console.log('newValue', newValue);
                console.log('errors', errors.fieldName);
            if(newValue === null){
                errors.fieldName.push('Nazwa pola jest wymagana!');
            }
            if(newValue !== "" && newValue.length < 6){
                errors.fieldName.push('Nazwa musi być dłuższa niż 6 znaków!')
            }
            }
        })
        
        watch(fieldCrop, (newValue)=>{
            if(saveFirstClicked.value){
                errors.fieldCrop = [];
                if(newValue === ""){
                    errors.fieldName.push('Uprawa jest wymagana!');
                }
            }
        })
        function checkForm(){
            errors.fieldName = [];
            errors.fieldCrop = [];
            errors.fieldParcels = [];
            if(fieldName.value && fieldCrop.value && fieldParcels.value){
                console.log('validacja pomyślna');
                return true;
            }
            
            if(!fieldName.value){
                console.log('brak fieldname');
                errors.fieldName.push('Nazwa pola jest wymagana');
            } 

            if(!fieldCrop.value){
                errors.fieldCrop.push('Uprawa jest wymagana');
            }
            if(fieldParcels.value.length === 0){
                errors.fieldParcels.push('Działki są wymagane');
            }
            return false;
        }
        provide('errors', errors);
        function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            console.log('submit wciśnięty');
            if(checkForm()){
                const formData = {
                    id: 13,
                    farm_id: 6,
                    field_name: fieldName.value,
                    fieldArea: 47,
                    crop: fieldCrop.value.name,
                    cadastral_parcels: fieldParcels.value,
                    created_at: "2022-08-26T09:39:47.000000Z",
                    updated_at: "2022-08-26T09:48:37.000000Z"
                };
                console.log('formData', formData);
                emit('submit-form', formData);
            }
            
        }
        const saveIsClicked = computed(()=>{
            return props.saveIsClicked;
        })
        watch(saveIsClicked, (newValue) => {
            if(newValue){
                submitForm();
            }
        })

        return {
            saveIsClicked,
            fieldName,
            requiredFieldNameLength,
            fieldArea,
            fieldCrop,
            updateCrop,
            crops,
            fieldParcels,
            parcels,
            updateParcelList,
            submitForm,
            errors
        }
    }
}
</script>
