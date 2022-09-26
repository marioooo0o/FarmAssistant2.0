<template>
    <div
        class="bg-white solid border-[1px] font-semibold border-fa-primary rounded-lg grid grid-cols-4 justify-center items-center text-xs box-border m-3 tracking-wider p-1 hover:ring-4 cursor-pointer">
        <div class="flex justify-center items-center">{{ field.field_name }}</div>
        <div class="flex justify-center items-center">{{field.field_area}} ha</div>
        <div class="flex justify-center items-center">
            <ul>
                <li v-for="parcel in field.cadastral_parcels" :key="field.cadastral_parcels.id">Działka {{parcel.parcel_number}}</li>
            </ul>
        </div>
        <div class="flex justify-center items-center">
            <div v-if="field.crop.image_path" class="flex-col">
                <div class="flex justify-center">
                    <img :src="field.crop.image_path" :alt=field.crop.name height="50px" width="50px" class="w-5"/>
                </div>
                <span>{{field.crop.name}}</span>
            </div>
            <span v-else>{{field.crop.name}}</span>
        </div>
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