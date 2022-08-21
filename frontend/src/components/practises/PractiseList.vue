<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <header class="bg-fa-primary rounded-t-lg text-white py-2 tracking-most-widest text-white-card relative">
                <div class="text-3xl text-center">Zabiegi</div>
                <span class="absolute flex right-0 top-0 pt-2 pr-2 cursor-pointer hover:text-fa-secondary"
                    @click="addPractise()">
                    Dodaj zabieg
                    <PlusCircleIcon class="flex items-center h-6 w-6" />
                </span>
                <div class="text-xl grid grid-cols-4 justify-center items-center m-1 ">
                    <div v-for="header in headers" :key="header.id"
                        class="flex justify-center items-center cursor-pointer hover:text-fa-secondary "
                        :class="[underlineIndex == header.id ? underlineClass : '']" @click="sortHeader(header.id)">
                        {{header.name}}</div>

                </div>
            </header>
            <div class="m-3">
                <PractiseListItem />
                <PractiseListItem />
                <PractiseListItem />
            </div>
            <BaseButton :class="'m-3 text-lg'">Załaduj więcej</BaseButton>
        </div>
    </BaseCard>
</template>
<script>
import {PlusCircleIcon} from '@heroicons/vue/outline'
import BaseCard from '../ui/BaseCard.vue'
import BaseButton from '../ui/BaseButton.vue'
import PractiseListItem from './PractiseListItem.vue'
export default {
    components:{
    PractiseListItem,
    BaseCard,
    BaseButton,
    PlusCircleIcon
},
data(){
    return{
        underlineIndex: 3,
        underlineClass: 'underline underline-offset-8 text-fa-secondary',
        headers: [
            {
                id: 0,
                name: 'Nazwa zabiegu'
            },
            {
                id: 1,
                name: 'Uprawa'
            },
            {
                id: 2,
                name: 'Pola'
            },
            {
                id: 3,
                name: 'Data wykonania'
            },
        ]
    }
},
methods: {
    sortHeader(headerId){
        this.underlineIndex = headerId;
    },
    addPractise(){
        console.log('Dodaj zabieg kliknięty');
    }
},
}
</script>
