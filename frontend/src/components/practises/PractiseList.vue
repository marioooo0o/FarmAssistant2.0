<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <CardHeader title="Zabiegi" addText="Dodaj zabieg"
                :headers="headers" :activeHeaderIndex="activeHeaderIndex"
                @add-new="$emit('show-create-page')"
                @selected-header="sortHeader"  />
            <div class="p-3" v-if="sortedList && sortedList.length !== 0">
                <PractiseListItem v-for="practise in sortedList" :key="practise.id" :practise="practise"
                    @click="$emit('show-description-page', practise.id)" />
            </div>
            <div class="m-3 py-6 text-lg" v-else>
                Nie posiadasz żadnych zabiegów
            </div>
            <BaseButton :class="'m-3 text-lg'" @click="handleLoadMore" v-if="sortedList && sortedList.length > 5">Załaduj więcej</BaseButton>
        </div>
    </BaseCard>
</template>
<script>
import { ref, provide, reactive, computed } from 'vue'
import {PlusCircleIcon} from '@heroicons/vue/outline'
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router'
import { mySort, sortAlphabetically, sortDescending } from '@/mylibs/sort.js';
import BaseCard from '../ui/BaseCard.vue'
import BaseButton from '../ui/BaseButton.vue'
import PractiseListItem from './PractiseListItem.vue'
import CardHeader from '../ui/CardHeader.vue'
export default {
    components:{
        PractiseListItem,
        BaseCard,
        BaseButton,
        PlusCircleIcon,
        CardHeader
    },
    props: {
        practisesList:{
            type: Object,
            required: true,
        }
    },
    emits: ['show-description-page', 'show-edit-page', 'show-create-page'],
    setup(props){
        const store = useStore(); 
        const route = useRoute();
        const router = useRouter();

        const headers = [
            {
                id: 0,
                name: 'Nazwa zabiegu',
                type: 'string',
                hoverIsAvaliable: true,
            },
            {
                id: 1,
                name: 'Uprawy',
                type: 'array',
            },
            {
                id: 2,
                name: 'Pola',
                type: 'array'
            },
            {
                id: 3,
                name: 'Data wykonania',
                type: 'date',
                hoverIsAvaliable: true,
            },
        ];

        const practisesListFromProp = computed(() => {
            return props.practisesList.length > 0 ? props.practisesList : [];
        });

        const sortedList = computed(() => {
            switch (selectedHeader.value) {
                case 0:
                    if (isAsc.value) {
                        return mySort(practisesListFromProp.value, (field) => field.name, sortAlphabetically);
                    }
                    else {
                        return mySort(practisesListFromProp.value, (field) => field.name, sortDescending);
                    }
                    break;
                case 3:
                    if (isAsc.value) {
                        return mySort(practisesListFromProp.value, (field) => field.start, sortAlphabetically);
                    }
                    else {
                        return mySort(practisesListFromProp.value, (field) => field.start, sortDescending);
                    }
                    break;
                default:
                    return practisesListFromProp.value;
            }
        });

        const activeHeaderIndex = ref(null);
        const prevIndex = ref(null);
        const isAsc = ref(true);

        const selectedHeader = ref(null);
        function sortHeader(headerId) {
            selectedHeader.value = headerId;
            activeHeaderIndex.value = headerId;
            if (activeHeaderIndex.value === prevIndex.value) {
                isAsc.value = !isAsc.value;
            } else {
                isAsc.value = true;
            }
            prevIndex.value = activeHeaderIndex.value;
        }

        async function handleLoadMore(){
            if(route.name !== 'practises'){
                router.push('/zabiegi-ochrony-roslin')
            }
            try{
                store.commit('toggleLoading');
                const response = await store.dispatch('practises/loadNextPractises'); 
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
            sortedList,
            sortHeader,
            activeHeaderIndex,
            handleLoadMore,
        }
    }
}
</script>
