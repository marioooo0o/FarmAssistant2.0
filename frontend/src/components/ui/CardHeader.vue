<template>
    <header class="bg-green-main rounded-t-lg text-white py-2 tracking-most-widest text-white-card relative">
        <div class="text-3xl text-center">{{ title }}</div>
        <span class="absolute flex right-0 top-0 pt-2 pr-2 cursor-pointer hover:text-yellow-300" @click="$emit('addNew')">
            {{ addText}}
            <PlusCircleIcon class="flex items-center h-6 w-6" />
        </span>
        <div class="text-xl grid grid-cols-4 justify-center items-center m-1 ">
            <div v-for="header in headers" :key="header.id"
                class="flex justify-center items-center cursor-pointer hover:text-yellow-300 "
                :class="[activeHeaderIndex == header.id ? underlineClass : '']" @click="$emit('selectedHeader', header.id)">
                {{ header.name }}</div>

        </div>
    </header>
</template>
<script>
import { ref } from 'vue';
import { PlusCircleIcon } from '@heroicons/vue/outline'
export default {
    components: {
        PlusCircleIcon
    },
    props:{
        title:{
            type: String,
            required: true
        },
        addText: {
            type: String,
            required: true
        },
        headers: {
            type: Object,
            required: true
        },
        activeHeaderIndex: {
            type: Number,
            required: true
        }
    },
    emits: ['addNew', 'selectedHeader'],
    setup(props) {
        const underlineClass = 'underline underline-offset-8 text-yellow-300';
        
        return {
            underlineClass,
        }
    }
}
</script>
