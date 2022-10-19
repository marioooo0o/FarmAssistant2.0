<template>

    <input v-if="auth"
        class="bg-gray-50 font-sans border-gray-500 border rounded-[10px] h-12 text-xl text-gray-500 focus:text-black max-w-md w-full px-4"
        :id="id" @input="$emit('update:modelValue', $event.target.value)" :required="required" 
        :disabled="disabled" :class="[{'cursor-not-allowed': disabled}, isInvalid]"
        :type="type" :value="modelValue" />

    <input v-else-if="id === 'postalCode'" class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" type="text" 
        :disabled="disabled" :class="[{'cursor-not-allowed': disabled},
        isInvalid]"
        :value="modelValue" pattern="^\d{2}-\d{3}$"
        :step="step" />

    <div v-else-if="unit">
        <input
            class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black" :id="id"
            @input="$emit('update:modelValue', $event.target.value)" :required="required" :type="type" :disabled="disabled"
            :class="[{'cursor-not-allowed': disabled}, isInvalid]" :value="modelValue" :placeholder="placeholder" :min="min"
            :step="step" />
        <span>{{unit}}</span>
        <el-input v-model="input" 
            class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black"
            :class="[{'cursor-not-allowed': disabled}, isInvalid]"
            :placeholder="placeholder">
        </el-input>
        <!-- <el-input v-model="input" :placeholder="placeholder">
            <template #suffix>
                <el-icon class="el-input__icon">
                    ha
                </el-icon>
            </template>
        </el-input> -->
    </div>
    <input v-else-if="unit" class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" :type="type" :disabled="disabled"
        :class="[{'cursor-not-allowed': disabled},
        isInvalid]" :value="modelValue" :placeholder="placeholder" :min="min"
        :step="step" />
    <input v-else class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" :type="type" 
        :disabled="disabled" :class="[{'cursor-not-allowed': disabled}, isInvalid]"
        :value="modelValue" :placeholder="placeholder"
        :min="min"
        :step="step" />
</template>
<script>
import { computed } from 'vue';
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
        disabled: Boolean,
        auth:{
            type: Boolean,
            default: false
        },
        min: {
            type: String,
            required: false
        },
        step: {
            type: String,
            required: false
        },
        error: Array,
        unit: String,
    },
    setup(props, {emit}) {
        
        const isInvalid = computed(() => {
            return (typeof props.error !== 'undefined' && props.error.length > 0) ? 'border-red-500 focus:outline-red-500' : 'border-fa-primary focus:outline-fa-primary'
        })
        return {
            isInvalid
        }
    }
    
};
</script>


