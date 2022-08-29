<template>
    <div class="flex flex-col">
        <input class="bg-input-bg border border-fa-primary text-lg h-8  text-center text-gray-500 focus:text-black focus:outline-fa-primary" :class="roundedClass" :id="id"
            :required="required" :type="type" :selectedInSearch="modelValue" :placeholder="placeholder"
            v-model="inputSearchQuery" @input="handleInput" />
        <ul v-if="inputSearchResults && isVisible" class="bg-input-bg border rounded-b-[10px]" ref="target">
            <li v-for="result in inputSearchResults" class="cursor-pointer hover:bg-yellow-200">
                <span class="flex items-center justify-center gap-4 my-2" @click="getSelectedValue(result.id)"><img
                        v-if="result.src" :src="result.src" :alt="result[searchKey]" class="w-6">{{ result[searchKey]}}</span>
            </li>
        </ul>
    </div>
</template>
<script>
import { ref, computed } from 'vue';
import { onClickOutside } from '@vueuse/core';
export default {
    props: {
        id: "",
        modelValue: "",
        required: Boolean,
        type: "",
        placeholder: {
            type: String,
            required: false
        },
        searchData: {
            type: Array,
            required: false
        },
        searchKey :{
            type: String,
            default: 'name'
        }
    },
    setup(props, { emit }) {
        const inputSearchQuery = ref("");
        const inputSearchResults = ref(null);
        function handleInput(event) {
            getSearchValues(props.searchKey);
        }
        function getSearchValues(key = "name"){
            if(inputSearchQuery.value !== ""){
                isVisible.value = true;
                if(key == 'parcel_number'){
                    inputSearchResults.value = props.searchData.filter((value) => value[key].toString().toLowerCase().startsWith(inputSearchQuery.value.toLowerCase().trim()));
                }
                else{
                    inputSearchResults.value = props.searchData.filter((value) => value[key].toLowerCase().startsWith(inputSearchQuery.value.toLowerCase().trim()));
                }
                
            }
        }
        const roundedClass = computed(()=>{
            if(inputSearchResults.value) return 'rounded-t-[10px]';
            else return 'rounded-[10px]';
        });

        function getSelectedValue(id){
            console.log('selected w base search', id);
            emit('selected-value', id);
            inputSearchQuery.value = "";
            inputSearchResults.value = null;
        }

        const target = ref(null);
        const isVisible = ref(true);
        onClickOutside(target, function(){
            if(inputSearchResults.value){
                isVisible.value = false;
                inputSearchQuery.value = "";
                inputSearchResults.value = null;
            }
            
        });
        return {
            inputSearchQuery,
            inputSearchResults,
            roundedClass,
            handleInput,
            getSelectedValue,
            target,
            isVisible
        }
    }

    
}
</script>
