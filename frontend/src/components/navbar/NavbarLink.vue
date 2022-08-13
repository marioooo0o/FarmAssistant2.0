<template>
    <div v-if="to" class="lg:inline-flex lg:w-auto px-3 py-2 text-3xl text-white tracking-most-widest hover:text-yellow-300"
        :class="[isActive ? underlineClass : '']">
        <router-link :to="to">
            <slot></slot>
        </router-link>
    </div>
    <div v-else class="lg:inline-flex lg:w-auto px-3 py-2 text-3xl text-white hover:text-yellow-300">
        <slot></slot>
    </div>
</template>
<script>
export default {
props:{
    to: String,
    active: Boolean
},
    data() {
        return {
            underlineClass: 'underline underline-offset-8 text-yellow-300',
        }
    },
computed:{
    isActive(){
        return this.$route.path == this.to;
},
}

}
</script>
