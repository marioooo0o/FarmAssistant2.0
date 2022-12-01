<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <CardHeader title="Pola" addText="Dodaj pole" 
                :headers="headers" :activeHeaderIndex="activeHeaderIndex"
                @add-new="$emit('show-create-page')" 
                @selected-header="sortHeader" />
            <div class="m-3" v-if="sortedList.length !== 0">
                <FieldListItem v-for="field in sortedList" :key="field.id" :field="field"
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
import { ref, provide, reactive, computed, onBeforeMount } from 'vue'
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import { mySort, sortAlphabetically, sortDescending } from '@/mylibs/sort.js';
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
            required: true
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
                name: 'Nazwa pola',
                type: 'string',
                hoverIsAvaliable: true,
            },
            {
                id: 1,
                name: 'Powierzchnia',
                type: 'number',
                hoverIsAvaliable: true,
            },
            {
                id: 2,
                name: 'Działki',
                type: 'array'
            },
            {
                id: 3,
                name: 'Uprawa',
                type: 'string',
                hoverIsAvaliable: true,
            },
        ];

        const fieldsListFromProp = computed(() => {
            return props.fieldsList.length > 0 ? props.fieldsList : [];
        });
        const sortedList = computed(() => {
            switch(selectedHeader.value){
                case 0:
                    if(isAsc.value){
                        return mySort(fieldsListFromProp.value, (field) => field.field_name, sortAlphabetically);
                    }
                    else{
                        return mySort(fieldsListFromProp.value, (field) => field.field_name, sortDescending);
                    }
                    break;
                case 1:
                    if(isAsc.value){
                        return mySort(fieldsListFromProp.value, (field) => field.field_area, sortAlphabetically);
                    }
                    else{
                        return mySort(fieldsListFromProp.value, (field) => field.field_area, sortDescending);
                    }
                    break;
                case 3:
                    if(isAsc.value){
                        return mySort(fieldsListFromProp.value, (field) => field.crop.name, sortAlphabetically);
                    }
                    else{
                        return mySort(fieldsListFromProp.value, (field) => field.crop.name, sortDescending);
                    }
                    break;
                default:
                    return fieldsListFromProp.value;
            }
        });

        const activeHeaderIndex = ref(null);
        const prevIndex = ref(null);
        const isAsc = ref(true);

        const selectedHeader = ref(null);
        function sortHeader(headerId){
            selectedHeader.value = headerId;
            activeHeaderIndex.value = headerId;
            if(activeHeaderIndex.value === prevIndex.value){
                isAsc.value = !isAsc.value;
            }else{
                isAsc.value = true;
            }
            prevIndex.value = activeHeaderIndex.value;
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
            Object.assign(selectedField, sortedList.value.find((field) => field.id === id))
        }

        function closeDescriptionCard(){
            descriptionIsShowed.value = false;
        }
        
        provide('descriptionIsShowed', descriptionIsShowed);

        async function handleLoadMore(){
            if(route.name !== 'fields'){
                router.push('/grunty');
            }
            try{
                store.commit('toggleLoading');
                const response = await store.dispatch('fields/loadNextFields'); 
                if(response && response.status === 401){
                    router.replace('/login');
                }
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
            handleLoadMore,
            sortedList
        }
    },
}
</script>
