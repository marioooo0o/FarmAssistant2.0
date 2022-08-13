<script>
import BaseInput from "@/components/ui/BaseInput.vue";
export default {
    components: {
        BaseInput,
    },
    methods: {
        handleInput(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
    props: {
        id: "",
        label: "",
        modelValue: "",
        required: Boolean,
        type: "",
    },
};
</script>

<template>
    <label class="flex flex-col text-2xl tracking-most-widest leading-10 max-w-md w-full" :for="id">
        {{ label }}
    </label>
    <BaseInput :id="id" @input="handleInput" :required="required" :type="type" :value="modelValue" />
</template>
