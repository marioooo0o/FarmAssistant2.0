<script>
import BaseInput from "@/components/ui/BaseInput.vue";
import BaseSearchInput from "./BaseSearchInput.vue";
export default {
    components: {
    BaseInput,
    BaseSearchInput,
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
        disabled: Boolean,
        type: "",
        placeholder:{
            type: String,
            required: false
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
        }
    },
};
</script>

<template>
    <div v-if="auth">
        <label class="flex flex-col text-2xl tracking-most-widest leading-10 max-w-md w-full" :for="id">
            {{ label }}
        </label>
        <BaseInput auth :id="id" @input="handleInput" :required="required" :disabled="disabled" :type="type" :value="modelValue" />
    </div>
    <div v-else-if="search" class="flex justify-between items-start text-lg">
        <label class="mr-2" :for="id">
            {{ label }}
        </label>
        <BaseSearchInput :id="id" :required="required" :disabled="disabled" :type="type" :placeholder="placeholder" :searchData="searchData"
            @selected-value="$emit('selected-value', $event)" />
        <span v-if="unit" class="ml-1">{{unit}}</span>
    </div>
    <div v-else class="flex justify-between items-center text-lg">
        <label class="mr-2" :for="id">
            {{ label }}
        </label>
        <BaseInput :id="id" @input="handleInput" :required="required" :disabled="disabled" :type="type" :value="modelValue"
            :placeholder="placeholder"
            :min="min"
            :step="step" />
        <span v-if="unit" class="ml-1">{{unit}}</span>
    </div>

</template>
