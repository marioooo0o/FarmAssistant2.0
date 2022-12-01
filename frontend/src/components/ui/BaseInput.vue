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
        <el-input v-model="input" class="focus:!border-red-600" :required="required" :type="type" :disabled="disabled" :min="min"
            :step="step" :class="[{'cursor-not-allowed': disabled}, isInvalid]"
            :style="{
                borderColor: isInvalid
            }">
            <template #suffix>
                <el-icon class="el-input__icon">
                    {{unit}}
                </el-icon>
            </template>
        </el-input>
    </div>
    <input v-else-if="date" class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" type="date" 
        :class="[{'cursor-not-allowed': disabled}, isInvalid]"
        :value="modelValue" />
    <!-- <input v-else-if="unit" class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" :type="type" :disabled="disabled"
        :class="[{'cursor-not-allowed': disabled}, isInvalid]"
        :value="modelValue" :placeholder="placeholder" :min="min"
        :step="step" /> -->
    <input v-else class="bg-input-bg border rounded-[10px] text-lg h-8 text-gray-500 text-center focus:text-black " :id="id"
        @input="$emit('update:modelValue', $event.target.value)" :required="required" :type="type" 
        :disabled="disabled" :class="[{'cursor-not-allowed': disabled}, isInvalid]"
        :value="modelValue" :placeholder="placeholder"
        :min="min"
        :step="step" />
</template>
<script>
import { ref, computed } from 'vue';
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
        date: Boolean,
    },
    setup(props, {emit, attrs}) {
        const input = ref(attrs.value ? attrs.value : '');
        const isInvalid = computed(() => {
            return (typeof props.error !== 'undefined' && props.error.length > 0) ? 'border-red-500 focus:outline-red-500' : 'border-fa-primary focus:outline-fa-primary'
        })
        return {
            input,
            isInvalid
        }
    }
    
};
</script>
<style>
.el-input{
    --el-input-focus-border-color: green
}
.el-input__wrapper{
    background-color: rgb(237 237 237 / var(--tw-bg-opacity)) !important;
    border-radius: 10px !important;
    border: 1px ;
}
.el-input__inner {
    background-color: rgb(237 237 237 / var(--tw-bg-opacity)) !important;
    height: 2rem;
    font-size: 1.125rem !important;
    line-height: 1.75rem;
    --tw-text-opacity: 1;
    color: rgb(107 114 128 / var(--tw-text-opacity));
    text-align: center;
    
}
.el-input__inner:focus{
    --tw-text-opacity: 1;
    color: rgb(0 0 0 / var(--tw-text-opacity));

}
</style>


