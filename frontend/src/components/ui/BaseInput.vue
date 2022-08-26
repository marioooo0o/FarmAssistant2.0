<script>
export default {
    methods: {
        handleInput(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
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
        }
    },
};
</script>

<template>

    <input v-if="auth"
        class="bg-gray-50 font-sans border-gray-500 border rounded-[10px] h-20 text-2xl text-gray-500 focus:text-black max-w-md w-full px-4"
        :id="id" @input="handleInput" :required="required" 
        :disabled="disabled" :class="{'cursor-not-allowed': disabled}"
        :type="type" :value="modelValue" />

    <input v-else class="bg-input-bg border rounded-[10px] border-fa-primary text-lg h-8 text-gray-500 text-center focus:text-black focus:outline-fa-primary" :id="id"
        @input="handleInput" :required="required" :type="type" 
        :disabled="disabled" :class="{'cursor-not-allowed': disabled}"
        :value="modelValue" :placeholder="placeholder"
        :min="min"
        :step="step" />
</template>
