<template>
    <div>
        <base-label search :id="id" :label="label" :type="type" :placeholder="placeholder" 
        :searchData="searchData"
        :searchKey="searchKey"
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
        }
    },
    emits: ['show-parcel-form', 'update-parcel-list'],
    setup(props, {emit}) {
        const selectedValues = ref(props.actualData);
        function getSelectedValue(id){
            console.log('id in psi', id);
            console.log('warunek', !selectedValues.value.find((result) => result.id === id));
                if (!selectedValues.value.find((result) => result.id === id)){
                    const selectedFromInput = props.searchData.find((result) => result.id === id);
                    console.log('psi selected', selectedFromInput);
                    console.log('psi selected', props.searchData);
                    emit('show-parcel-form', selectedFromInput);
                    // selectedValues.value.push(props.searchData.find((result) => result.id === id))
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