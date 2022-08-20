<template>
    <BaseCard>
        <div class="text-center font-semibold">
            <header class="bg-green-main rounded-t-lg text-white py-2 tracking-most-widest text-white-card relative">
                <div class="text-3xl text-center">Pola</div>
                <span class="absolute flex right-0 top-0 pt-2 pr-2 cursor-pointer hover:text-yellow-300"
                    @click="addField()">
                    Dodaj pole
                    <PlusCircleIcon class="flex items-center h-6 w-6" />
                </span>
                <div class="text-xl grid grid-cols-4 justify-center items-center m-1 ">
                    <div v-for="header in headers" :key="header.id"
                        class="flex justify-center items-center cursor-pointer hover:text-yellow-300 "
                        :class="[underlineIndex == header.id ? underlineClass : '']" @click="sortHeader(header.id)">
                        {{ header.name }}</div>

                </div>
            </header>
            <div class="m-3">
                <FieldListItem @click="toggleIsShowed()" />
                <FieldListItem @click="toggleIsShowed()" />
                <FieldListItem @click="toggleIsShowed()" />
            </div>
            <BaseButton :class="'m-3 text-lg'" @click="toggleIsShowed()">Załaduj więcej</BaseButton>
            <FieldDescription />
        </div>
    </BaseCard>
</template>
<script>
import { PlusCircleIcon } from '@heroicons/vue/outline'
import BaseCard from '../ui/BaseCard.vue'
import BaseButton from '../ui/BaseButton.vue'
import FieldListItem from './FieldListItem.vue'
import BaseDescriptionCard from '../ui/BaseDescriptionCard.vue'
import FieldDescription from './FieldDescription.vue'
import { computed } from 'vue'
export default {
    components: {
    FieldListItem,
    BaseCard,
    BaseButton,
    PlusCircleIcon,
    BaseDescriptionCard,
    FieldDescription
},
    data() {
        return {
            descriptionIsShowed: false,
            underlineIndex: 3,
            underlineClass: 'underline underline-offset-8 text-yellow-300',
            headers: [
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
            ],
            
        }
    },
    provide() {
        return {
            // explicitly provide a computed property
            descriptionIsShowed: computed(() => this.descriptionIsShowed)
        }
    },
    methods: {
        toggleIsShowed(){
            this.descriptionIsShowed = !this.descriptionIsShowed;
            console.log(this.descriptionIsShowed);
        },
        sortHeader(headerId) {
            this.underlineIndex = headerId;
        },
        addField() {
            console.log('Dodaj pole kliknięty');
        },
        
        closeDesc(){
        }
    },
}
</script>
