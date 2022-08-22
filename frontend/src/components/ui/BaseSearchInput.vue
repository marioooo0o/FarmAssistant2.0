<template>
    <div class="flex flex-col">
        <input class="bg-input-bg border border-black text-lg h-8  text-center" :class="roundedClass" :id="id"
            :required="required" :type="type" :selectedInSearch="modelValue" :placeholder="placeholder"
            v-model="inputSearchQuery" @input="handleInput" />
        <ul v-if="inputSearchResults" class="bg-input-bg border rounded-b-[10px]">
            <li v-for="result in inputSearchResults" class="cursor-pointer hover:bg-gray-300">
                <span class="flex items-center justify-center gap-4 my-2" @click="getSelectedValue(result.id)"><img
                        v-if="result.src" :src="result.src" :alt="result.name" class="w-6">{{ result.name}}</span>
            </li>
        </ul>
    </div>
</template>
<script>
import { ref, computed } from 'vue'
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
        }
    },
    setup(props, { emit }) {
        const inputSearchQuery = ref("");
        const inputSearchResults = ref(null);
        function handleInput(event) {
            getSearchValues();
        }
        function getSearchValues(){
            if(inputSearchQuery.value !== ""){
                inputSearchResults.value = props.searchData.filter((value) => value.name.toLowerCase().startsWith(inputSearchQuery.value.toLowerCase().trim()));
            }
        }
        const roundedClass = computed(()=>{
            if(inputSearchResults.value) return 'rounded-t-[10px]';
            else return 'rounded-[10px]';
        });

        function getSelectedValue(id){
            emit('selected-value', id);
            inputSearchQuery.value = "";
            inputSearchResults.value = null;
        }

        return {
            inputSearchQuery,
            inputSearchResults,
            roundedClass,
            handleInput,
            getSelectedValue,
        }
    }

    
}
</script>
