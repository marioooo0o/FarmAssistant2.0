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
        auth:{
            type: Boolean,
            default: false
        }
    },
};
</script>

<template>

    <input v-if="auth"
        class="bg-gray-50 font-sans border-gray-500 border rounded-[10px] h-20 text-2xl text-gray-500 focus:text-black max-w-md w-full px-4"
        :id="id" @input="handleInput" :required="required" :type="type" :value="modelValue" />

    <input v-else class="bg-input-bg border rounded-[10px] border-black text-lg h-8  text-center" :id="id"
        @input="handleInput" :required="required" :type="type" :value="modelValue" :placeholder="placeholder" />
</template>
