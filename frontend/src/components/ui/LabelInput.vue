<template>
    <div v-if="auth">
        <label class="flex flex-col text-2xl tracking-most-widest leading-10 max-w-md w-full" :for="id">
            {{ label }}
        </label>
        <div>
            <BaseInput auth :id="id" @input="handleInput" :required="required" :disabled="disabled" :type="type" :value="modelValue" :name="name" />
            <span>Error</span>
        </div>
    </div>
    <div v-else-if="search" class="grid grid-cols-2 items-center text-lg">
        <label class="mr-2" :for="id">
            {{ label }}
        </label>
        <BaseSearchInput :id="id" :required="required" :disabled="disabled" :type="type" :placeholder="placeholder" :name="name"
        :searchData="searchData"
        :searchKey="searchKey"
        :error="error"
            @selected-value="$emit('selected-value', $event)" />
        <ul v-if="hasError" class="col-start-2 text-red-500 text-sm">
                <li v-for="e in error" :key="e">{{e}}</li>
        </ul>
    </div>
    <div v-else class="grid grid-cols-2 items-center">
        <label class="mr-2 text-lg" :for="id">
            {{ label }}
        </label>
        <BaseInput :id="id" @input="$emit('update:modelValue', $event.target.value)" :required="required" :disabled="disabled" :type="type" :value="modelValue" :name="name"
            :placeholder="placeholder"
            :min="min"
            :step="step"
            :error="error" />
            <ul v-if="hasError" class="col-start-2 text-red-500 text-sm">
                <li v-for="e in error" :key="e">{{e}}</li>
            </ul>
    </div>
    <!-- 
         <span v-if="unit" class="ml-1">{{unit}}</span> 
     -->

</template>
<script>
import { computed } from 'vue';
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseSearchInput from "./BaseSearchInput.vue";
export default {
    components: {
        BaseInput,
        BaseSearchInput,
    },
    props: {
        id: "",
        label: "",
        modelValue: "",
        required: Boolean,
        disabled: Boolean,
        type: "",
        placeholder:{
            type: String,
            required: false
        },
        name: {
            type: String
        },
        search : {
            type: Boolean,
            required: false
        },
        searchData: {
            type: Array,
            required: false
        },
        auth: {
            type: Boolean,
            default: false
        },
        unit:{
            type: String,
            required: false
        },
        min: {
            type: String,
            required: false
        },
        step: {
            type: String,
            required: false
        },
        searchKey :{
            type: String,
        },
        error: Array,
    },
    setup(props, { emit }) {
        
        
        const hasError = computed(()=>{
            return (typeof props.error !== 'undefined' && props.error.length > 0) ? true : false
        })
        return {
            hasError
        }
    },
    
};
</script>


