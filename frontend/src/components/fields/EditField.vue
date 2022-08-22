<template>
    <base-description-card @close-description-card="$emit('close-edit-card')">
        <div class="flex flex-col items-center font-semibold tracking-wider">
            <h1 class="text-2xl">Edytuj Pole</h1>
            <form>
                <base-form-control>
                    <base-label id="fieldName" label="Nazwa Pola:" required v-model="fieldName" type="text" />
                </base-form-control>
                <base-form-control>
                    <base-label id="fieldArea" label="Powierzchnia:" required v-model="fieldArea" type="number" />
                </base-form-control>
                <base-form-control>
                    <SearchFormControl search id="fieldCrop" label="Uprawa:" required placeholder="wyszukaj uprawę:"
                        :searchData="crops" :actualData="fieldCrop" />
                </base-form-control>
                <base-form-control>
                    <SearchFormControl search id="fieldParcels" label="Działki:" required placeholder="wyszukaj działkę:"
                        :searchData="parcels" :actualData="fieldParcels" />
                </base-form-control>

            </form>
        </div>
    </base-description-card>
</template>

<script>
import { ref } from 'vue';
import BaseDescriptionCard from '../ui/BaseDescriptionCard.vue';
import BaseFormControl from '../ui/BaseFormControl.vue';
import SearchFormControl from '../ui/SearchFormControl.vue';
export default {
    components: { BaseDescriptionCard, BaseFormControl, BaseFormControl, SearchFormControl },
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-edit-card'],
    setup(props) {
        const fieldName = ref(props.field.name);

        const fieldArea = ref(props.field.area);

        const fieldCrop = ref(props.field.crop);

        function handleDeleteCropClicked() {
            fieldCrop.value = null;
        }

        const cropSearchQuery = ref('');
        const cropSearchResults = ref(null);
        
        const crops = [
            {
                id: 1,
                name: 'Tomato',
                src: '/src/assets/crops/tomato.png',
            },
            {
                id: 2,
                name: 'Ogorek',
                src: '/src/assets/crops/tomato.png',
            },
            {
                id: 3,
                name: 'Pszenica',
                src: '/src/assets/crops/tomato.png',
            },
            {
                id: 4,
                name: 'Trzcina',
                src: '/src/assets/crops/tomato.png',
            },
        ];
        const getSearchCrop = () => {
            if (cropSearchQuery.value !== ""){
                cropSearchResults.value = crops.filter(crop => crop.name.toLowerCase().startsWith(cropSearchQuery.value.toLowerCase().trim())
                );
            }
        }

        const fieldParcels = ref(props.field.parcels);
        const parcels = [
            {
                "id": 1,
                "name": "12345",
                "parcel_area": 24,
                "pivot": {
                    "field_id": 5,
                    "cadastral_parcel_id": 1,
                    "area": 4.8,
                    "created_at": "2022-08-03T05:04:47.000000Z",
                    "updated_at": "2022-08-03T05:04:47.000000Z"
                }
            },
            {
                "id": 2,
                "name": "123456",
                "parcel_area": 26,
                "pivot": {
                    "field_id": 5,
                    "cadastral_parcel_id": 2,
                    "area": 5.2,
                    "created_at": "2022-08-03T05:04:47.000000Z",
                    "updated_at": "2022-08-03T05:04:47.000000Z"
                }
            }
        ]
        function handleDeleteParcelClicked(id){
            fieldParcels.value =  fieldParcels.value.filter(parcel => parcel.id !== id);
        }
        return{
            fieldName,
            fieldArea,
            fieldCrop,
            crops,
            cropSearchQuery,
            cropSearchResults,
            getSearchCrop,
            handleDeleteCropClicked,
            handleDeleteParcelClicked,
            fieldParcels,
            parcels
        }
    }
}
</script>
