<template>
    <div
        class="bg-white solid border-[1px] font-semibold border-fa-primary rounded-lg grid grid-cols-4 justify-center items-center text-xs box-border m-3 tracking-wider p-1 hover:ring-4 cursor-pointer">
        <div class="flex justify-center items-center">{{practise.name}}</div>
        <div class="flex justify-center items-center">
            <img v-for="crop in practiseCrops" :key="crop.id" :src="crop.image_path" :alt="crop.name"  height="50px" width="50px" class="w-5">
        </div>
        <div class="flex justify-center items-center">
            <ul>
                <li v-for="field in practise.fields" :key="field.id">{{field.field_name}}</li>
            </ul>
        </div>
        <div class="flex justify-center items-center">{{practise.start}}</div>
    </div>
</template>
<script>
import {computed} from 'vue';
export default {
    props: {
        practise: {
            type: Object, 
            required: true,
        }
    },
    setup(props){
        const practiseCrops = computed(()=>{
            const map = {};
            for (const field of props.practise.fields) {
                if (!map[field.crop.image_path]) {
                    map[field.crop.image_path] = field.crop;
                }
            }
            return Object.values(map);
        });

        return {
            practiseCrops
        }
    }
}
</script>
<style>
    
</style>