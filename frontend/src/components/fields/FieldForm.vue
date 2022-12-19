<template>
    <form @submit.prevent="submitForm">
        <base-form-control>
            <base-label id="fieldName" label="Nazwa Pola:" required v-model.trim="fieldName" type="text" name="fieldName" :error="errors['fieldName']" />
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
                    @show-parcel-form="showParcelForm"
                    @update-parcel-list="updateParcelList" />
        </base-form-control>
        <base-form-control>
            <base-label id="fieldArea" label="Powierzchnia:" required v-model="fieldArea" type="number" disabled unit="ha"/>
        </base-form-control>
</form>
</template>
<script>
import { ref, reactive, computed, watch, provide, onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';
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
        },
        typeForm:{
            type: String,
            required: true,
        }
    },
    emits: ['show-parcel-form', 'submit-form', 'set-field-attr'],
    setup(props, {emit}){
        const store = useStore();
        const router = useRouter();

        onBeforeMount(async() => {
                store.commit('toggleLoading');
                const resCrops = await store.dispatch('fields/loadCrops');
                if(resCrops && resCrops.status === 401){
                    router.replace('/login');
                }
                const resPracels = await store.dispatch('fields/loadCadastralParcels'); 
                if(resPracels && resPracels.status === 401){
                    router.replace('/login');
                }
                store.commit('toggleLoading');
        });

        const fieldName = ref(props.field.field_name ? props.field.field_name : "");
        const requiredFieldNameLength = ref(5);
            

        const fieldParcels = ref(props.field.cadastral_parcels ? props.field.cadastral_parcels : []);

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
            fieldCrop.value = crop
        }

        const crops = computed(()=>{
            return store.getters['fields/allCrops'];
        });

        const parcels = computed(()=>{
            return store.getters['fields/allParcels'];
        });

        function showParcelForm($event){
            const formData = {
                field_name: fieldName.value,
                crop: fieldCrop.value,
                cadastral_parcels: fieldParcels.value,
            }
            emit('set-field-attr', formData);
            emit('show-parcel-form', $event)
        }

        function updateParcelList(parcelList){
            fieldParcels.value = parcelList;
        }
        const errors = reactive({
            fieldName: [],
            fieldCrop: [],
            fieldParcels: [],
        });

        const saveFirstClicked = ref(false);
        watch(fieldName, (newValue)=>{
            if(saveFirstClicked.value){
                errors.fieldName = [];
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
            if(fieldName.value && fieldCrop.value && fieldParcels.value.length !== 0){
                return true;
            }
            
            if(!fieldName.value){
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
        async function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    field_name: fieldName.value,
                    crop: fieldCrop.value.name,
                    cadastral_parcels: []
                }
                fieldParcels.value.forEach(element => {
                    const p = {
                        parcel_number: element.parcel_number,
                        area: element.pivot.area
                    }
                    formData.cadastral_parcels.push(p);
                });

                store.commit('toggleLoading');
                let response = null;
                if(props.typeForm === 'add'){
                    response = await store.dispatch('fields/addNewField', formData)
                }
                else{
                    formData['field_id'] = props.field.id;
                    response = await store.dispatch('fields/editField', formData)
                }
                if(response.status === 201){
                    store.commit('response/setResponse', {
                        status: response.success,
                        message: 'Nowe pole dodane pomyślnie!'
                    }, {root: true});
                    emit('submit-form', response);
                }
                else if(response.status === 200){
                    store.commit('response/setResponse', {
                        status: true,
                        message: 'Pole edytowane pomyślnie!'
                    }, {root: true});
                    emit('submit-form', response);
                }
                else if(response.status === 422){
                    errors.fieldName = [];
                    errors.fieldParcels = [];
                    errors.fieldCrop = [];
                    for(let e in response.errors){
                        switch(e){
                            case 'field_name':{
                                errors.fieldName.push(...response.errors[e]);
                                break;
                            }
                            case 'cadastral_parcels': {
                                errors.fieldParcels.push(...response.errors[e]);
                                break;
                            }
                            case 'crop':{
                                errors.fieldCrop.push(...response.errors[e]);
                                break;
                            }
                        }
                    }
                }
                else if(response.status === 401){
                    router.replace('/login');
                }
                store.commit('toggleLoading');
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
            showParcelForm,
            submitForm,
            errors
        }
    }
}
</script>
