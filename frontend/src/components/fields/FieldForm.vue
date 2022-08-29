<template>
    <form @submit.prevent="submitForm">
        <base-form-control>
            <base-label id="fieldName" label="Nazwa Pola:" required v-model="fieldName" type="text" />
        </base-form-control>
        <base-form-control>
            <base-label id="fieldArea" label="Powierzchnia:" required v-model="fieldArea" type="number" unit="ha" disabled />
        </base-form-control>
        <base-form-control>
            <SearchFormControl search id="fieldCrop" label="Uprawa:" required placeholder="wyszukaj uprawę:"
                :searchData="crops" :actualData="fieldCrop"
                @update-search-list="updateCrop" />
        </base-form-control>
        <base-form-control>
            <ParcelSearchInput search id="fieldParcels" label="Działki:" required placeholder="wyszukaj działkę:"
                :searchData="parcels" :actualData="fieldParcels"
                searchKey="parcel_number"
                @show-parcel-form="$emit('show-parcel-form', $event)"
                @update-parcel-list="updateParcelList" />
        </base-form-control>
    </form>
</template>
<script>
import { ref, computed, watch } from 'vue';
import { useStore } from 'vuex'
import SearchFormControl from '../ui/SearchFormControl.vue';
import ParcelSearchInput from './ParcelSearchInput.vue';
export default {
    components: { 
        SearchFormControl, 
        ParcelSearchInput },
    props:{
        field:{
            type: Object,
            required: false
        },
        saveIsClicked:{
            type: Boolean,
            default: false,
        }
    },
    emits: ['show-parcel-form', 'submit-form'],
    setup(props, {emit}){
        const store = useStore()

        const fieldName = computed(()=>{
            return props.field.field_name ? props.field.field_name : ""
        });

        const fieldParcels = ref(props.field.cadastral_parcels ? props.field.cadastral_parcels : "");

        const fieldArea = computed(()=>{
            return fieldParcels.value.reduce((acc, item) => acc + (item.pivot.area ? item.pivot.area : 0), 0)
        });

        const fieldCrop = ref(props.field.crop ? props.field.crop : "");

        function updateCrop(crop){
            fieldCrop.value = crop
        }

        const crops = computed(()=>{
            return store.getters['fields/allCrops'];
        });

        const parcels = computed(()=>{
            return store.getters['fields/allParcels'];
        });

        function updateParcelList(parcelList){
            fieldParcels.value = parcelList;
        }
        function submitForm(){
            const formData = {
                field_name: fieldName.value,
                crop: fieldCrop.value.name,
                cadastral_parcels: fieldParcels.value
            };
            emit('submit-form', formData);
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
            fieldArea,
            fieldCrop,
            updateCrop,
            crops,
            fieldParcels,
            parcels,
            updateParcelList,
            submitForm
        }
    }
}
</script>
