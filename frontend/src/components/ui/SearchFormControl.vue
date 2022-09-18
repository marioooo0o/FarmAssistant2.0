<template>
    <div>
        <base-label search :id="id" :label="label" :type="type" :placeholder="placeholder" :name="name" :searchData="searchData" 
            :error="error"
            @selected-value="getSelectedValue"
             />
        <ul v-if="selectedValues && isArray" class="flex flex-col items-end mr-4">
            <li v-for="value in selectedValues" :key="value.id">
                <span class="flex items-center justify-center gap-4 my-2"><img v-if="value.src" :src="value.src"
                        :alt="value.name" class="w-6">{{ value.name}}
                    <i class="fa-regular fa-trash-can text-2xl cursor-pointer ml-3 hover:text-red-500"
                        @click="handleDeleteItem(value.id)"></i></span>
            </li>
        </ul>
        <ul v-if="selectedValues && !isArray" class="flex justify-end mr-4">
            <li>
                <span class="flex items-center justify-center gap-4 my-2">
                    <img v-if="selectedValues.image_path" :src="selectedValues.image_path" :alt="selectedValues.name" class="w-6">
                    {{ selectedValues.name}}
                    <i class="fa-regular fa-trash-can text-2xl cursor-pointer ml-3 hover:text-red-500"
                        @click="handleDeleteItem(selectedValues.id)">
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
        name: String,
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
        error: Array,
    },
    emits: ['update-search-list'],
    setup(props, {emit}) {
        const selectedValues = ref(props.actualData);
        const isArray = ref(Array.isArray(selectedValues.value));

        function getSelectedValue(id){
            if(isArray.value){
                if ((!selectedValues) || (!selectedValues.value.find((result) => result.id === id))){
                    selectedValues.value.push(props.searchData.find((result) => result.id === id))
                }
            }else{
                if ((!selectedValues.value) || (selectedValues.value && id !== selectedValues.value.id)) {
                    selectedValues.value = props.searchData.find((result) => result.id === id);
                }
            }
            emit('update-search-list', selectedValues.value);
            
        }

        function handleDeleteItem(id){
            if(isArray.value){
                selectedValues.value = selectedValues.value.filter((value) => value.id !== id);
            }
            else{
                selectedValues.value = null;
            }
            emit('update-search-list', selectedValues.value);
        }

        return {
            selectedValues,
            isArray,
            getSelectedValue,
            handleDeleteItem
        }
    }
}
</script>
