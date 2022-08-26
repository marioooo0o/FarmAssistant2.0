<template>
    <div
        class="bg-white solid border-[1px] font-semibold border-fa-primary rounded-lg grid grid-cols-4 justify-center items-center text-xs box-border m-3 tracking-wider p-1 hover:ring-4 cursor-pointer">
        <div class="flex justify-center items-center">{{ field.field_name }}</div>
        <div class="flex justify-center items-center">{{field.area}} ha</div>
        <div class="flex justify-center items-center">
            <ul>
                <li v-for="parcel in field.parcels" :key="field.parcels.id">Działka {{parcel.name}}</li>
            </ul>
        </div>
        <div class="flex justify-center items-center"><img :src="field.crop.src" :alt=field.crop.alt height="50px" width="50px" class="w-5"></div>
    </div>
</template>
<script>
export default {
    props:{
        field:{
            type: Object,
            required: true
        }
    }
}
</script>
<style>
</style>