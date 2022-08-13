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
    },
};
</script>

<template>
    <input
        class="bg-gray-50 font-sans border-gray-500 border rounded-[10px] h-20 text-2xl text-gray-500 focus:text-black max-w-md w-full px-4"
        :id="id" @input="handleInput" :required="required" :type="type" :value="modelValue" />
</template>
