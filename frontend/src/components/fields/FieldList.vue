<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <CardHeader title="Pola" addText="Dodaj pole" 
                :headers="headers" :activeHeaderIndex="activeHeaderIndex"
                @add-new="$emit('show-create-page')" 
                @selected-header="sortHeader" />
            <div class="m-3" v-if="fieldsList.length !== 0">
                <FieldListItem v-for="field in fieldsList" :key="field.id" :field="field"
                    @click="$emit('show-description-page', field.id)" />
            </div>
            <div class="m-3 text-lg" v-else>
                Nie posiadasz żadnych pół
            </div>
            <BaseButton :class="'m-3 text-lg'" @click="handleLoadMore">Załaduj więcej</BaseButton>
        </div>
    </BaseCard>
</template>
<script>
import { ref, provide, reactive } from 'vue'
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
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
    props: {
        fieldsList:{
            type:Object,
        }
    },
    emits:['show-description-page','show-edit-page', 'show-create-page'],
    setup(props) {
        const store = useStore(); 
        const route = useRoute();
        const router = useRouter();

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

        const activeHeaderIndex = ref(3);

        function sortHeader(headerId){
            switch(headerId){
                case 0:
                    if(activeHeaderIndex === headerId){
                        props.fieldsList.sort((a, b) => a.name < b.name ? 1 : -1);
                    }
                    else{
                        props.fieldsList.sort((a, b) => a.name > b.name ? 1 : -1);
                    }
                    break;
                case 1:
                    props.fieldsList.sort((a,b)=> a.area > b.area ? 1: -1);
            }
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
            descriptionIsShowed.value = true;
            Object.assign(selectedField, fieldsList.find((field) => field.id === id))
        }

        function closeDescriptionCard(){
            descriptionIsShowed.value = false;
        }
        
        provide('descriptionIsShowed', descriptionIsShowed);

        async function handleLoadMore(){
            if(route.name !== 'grunty'){
                router.push('/grunty');
            }
            try{
                store.commit('toggleLoading');
                await store.dispatch('fields/loadNextFields'); 
                store.commit('toggleLoading');
            }
            catch(e){
                alert(e)
            }
        }

        return {
            headers,
            activeHeaderIndex,
            sortHeader,
            toggleToShow,
            descriptionIsShowed,
            selectedField,
            closeDescriptionCard,
            handleLoadMore
        }
    },
}
</script>
