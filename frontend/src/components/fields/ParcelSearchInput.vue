<template>
    <div>
        <base-label search :id="id" :label="label" :type="type" :placeholder="placeholder" 
        :searchData="searchData"
        :searchKey="searchKey"
        :error="error"
        @selected-value="getSelectedValue" />
        <ul v-if="selectedValues" class="flex flex-col items-end mr-4">
            <li v-for="value in selectedValues" :key="value.id" class="flex items-center justify-center">
                <span class="my-2">
                    Działka: {{ value.parcel_number}} {{value.pivot.area}}ha
                </span>
                <span class="flex gap-1 ml-2">
                    <i class="fa-regular fa-pen-to-square text-2xl cursor-pointer text-fa-primary hover:text-fa-secondary"
                        @click="$emit('show-parcel-form', value)"></i>
                    <i class="fa-regular fa-trash-can text-2xl cursor-pointer hover:text-red-500"
                        @click="handleDeleteItem(value.id)">
                    </i>
                </span>
            </li>
        </ul>
    </div>
</template>
<script>
import { ref } from 'vue';
export default {
    props: {
        id: "",
        label: "",
        modelValue: "",
        required: Boolean,
        type: "",
        placeholder: {
            type: String,
            required: false
        },
        search: {
            type: Boolean,
            required: false
        },
        searchData: {
            type: Array,
            required: false
        },
        actualData: {
            type: [Array, Object]
        },
        searchKey :{
            type: String,
            default: 'name'
        },
        error: Array,
    },
    emits: ['show-parcel-form', 'update-parcel-list'],
    setup(props, {emit}) {
        const selectedValues = ref(props.actualData);
        function getSelectedValue(id){
            
                if (selectedValues.value && !selectedValues.value.find((result) => result.id === id)){
                    const selectedFromInput = props.searchData.find((result) => result.id === id);
                    emit('show-parcel-form', selectedFromInput);
                }
                else if(!selectedValues.value){
                    const selectedFromInput = props.searchData.find((result) => result.id === id);
                    emit('show-parcel-form', selectedFromInput);
                }
        }
        
        function handleDeleteItem(id){
            selectedValues.value.splice(selectedValues.value.findIndex((result) => result.id === id),1);
            //  = selectedValues.value.filter((value) => value.id !== id);
            // selectedValues.value = selectedValues.value.filter((value) => value.id !== id);
            emit('update-parcel-list', selectedValues.value);
        }

        return {
            selectedValues,
            getSelectedValue,
            handleDeleteItem,
        }
    }
    
}
</script>
<style>
    
</style>