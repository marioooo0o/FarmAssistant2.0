<template>
    <header class="bg-fa-primary rounded-t-lg text-white py-2 tracking-most-widest text-white-card relative">
        <div class="text-3xl text-center">{{ title }}</div>
        <span class="absolute flex right-0 top-0 pt-2 pr-2 cursor-pointer hover:text-fa-secondary" @click="$emit('addNew')">
            {{ addText}}
            <PlusCircleIcon class="flex items-center h-6 w-6" />
        </span>
        <div class="text-xl grid justify-center items-center m-1" :class="gridCols">
            <div v-for="header in headers" :key="header.id"
                class="flex justify-center items-center"
                :class="[
                    header.hoverIsAvaliable ? 'hover:text-fa-secondary cursor-pointer ' : '',
                    (activeHeaderIndex == header.id &&  header.hoverIsAvaliable)? underlineClass : ''
                    ]" @click="$emit('selectedHeader', header.id)">
                {{ header.name }}</div>

        </div>
    </header>
</template>
<script>
import { ref, computed } from 'vue';
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
        const underlineClass = 'underline underline-offset-8 text-fa-secondary';
        const headersCount = computed(() => {
            return props.headers.length
        });
        const gridCols = `grid-cols-${headersCount.value}`
        return {
            underlineClass,
            gridCols
        }
    }
}
</script>
