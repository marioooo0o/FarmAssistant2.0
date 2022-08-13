<script>
export default {
    props: {
        class: String,
        link: Boolean,
        to: String
    },
};
</script>

<template>
    <button v-if="!link"
        class="bg-gradient-to-br from-green-600 via-green-500 to-green-400 p-2 text-white rounded-[10px] max-w-xs w-full tracking-most-widest transition-[background] bg-[length:200%] hover:bg-right"
        :class="class">
        <slot></slot>
    </button>
    <router-link v-else :to="to"
        class="bg-gradient-to-br from-green-600 via-green-500 to-green-400 p-2 text-white rounded-[10px] max-w-xs w-full tracking-most-widest flex justify-center items-center transition-[background] bg-[length:200%] hover:bg-right"
        :class="class">
        <slot></slot>
    </router-link>
</template>
