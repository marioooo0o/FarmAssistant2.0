<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <CardHeader title="Pola" addText="Dodaj pole" :headers="headers" :activeHeaderIndex="activeHeaderIndex"
                @add-new="addField()" @selected-header="sortHeader" />
            <div class="m-3">
                <FieldListItem v-for="field in fieldsList" :key="field.id" :field="field"
                    @click="toggleToShow(field.id)" />
            </div>
            <BaseButton :class="'m-3 text-lg'" @click="">Załaduj więcej</BaseButton>
            <FieldDescription v-if="descriptionIsShowed" :field="selectedField" @close-description-card="closeDescriptionCard" />
        </div>
    </BaseCard>
</template>
<script>
import { ref, provide, reactive } from 'vue'

import BaseCard from '../ui/BaseCard.vue'
import BaseButton from '../ui/BaseButton.vue'
import CardHeader from '../ui/CardHeader.vue'
import FieldListItem from './FieldListItem.vue'
import BaseDescriptionCard from '../ui/BaseDescriptionCard.vue'
import FieldDescription from './FieldDescription.vue'
export default {
    components: {
    FieldListItem,
    BaseCard,
    BaseButton,
    CardHeader,
    BaseDescriptionCard,
    FieldDescription
    },
    setup() {
        const headers = [
            {
                id: 0,
                name: 'Nazwa pola'
            },
            {
                id: 1,
                name: 'Powierzchnia'
            },
            {
                id: 2,
                name: 'Działki'
            },
            {
                id: 3,
                name: 'Uprawa'
            },
        ];

        const fieldsList = [
            {
                id: 0,
                name: 'Pole Romana',
                area: 11.0,
                parcels: [
                    {
                        id:1,
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
        const activeHeaderIndex = ref(3);

        function sortHeader(headerId){
            switch(headerId){
                case 0:
                    if(activeHeaderIndex === headerId){
                        fieldsList.sort((a, b) => a.name < b.name ? 1 : -1);
                    }
                    else{
                        fieldsList.sort((a, b) => a.name > b.name ? 1 : -1);
                    }
                    break;
                case 1:
                    fieldsList.sort((a,b)=> a.area > b.area ? 1: -1);
            }
            console.log('wybrany header', headerId);
            activeHeaderIndex.value = headerId;
        }
        const descriptionIsShowed = ref(false);
        const selectedField = reactive({
            id: null,
            name: '',
            area: null,
            parcels: [],
            crop: {}
        });
        function toggleToShow(id){
            console.log('id to:', id);
            descriptionIsShowed.value = true;
            Object.assign(selectedField, fieldsList.find((field) => field.id === id))
        }

        function closeDescriptionCard(){
            descriptionIsShowed.value = false;
        }
        function addField(){
            console.log('Dodaj pole klikniety');
        }

        provide('descriptionIsShowed', descriptionIsShowed);
        return {
            addField,
            headers,
            fieldsList,
            activeHeaderIndex,
            sortHeader,
            toggleToShow,
            descriptionIsShowed,
            selectedField,
            closeDescriptionCard
        }
    },
}
</script>
