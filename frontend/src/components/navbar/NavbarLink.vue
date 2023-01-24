<template>
    <div v-if="to" class="lg:inline-flex lg:w-auto px-3 py-2 text-3xl text-white tracking-most-widest hover:text-fa-secondary"
        :class="[isActive ? underlineClass : '']">
        <router-link :to="to">
            <slot></slot>
        </router-link>
    </div>
    <div v-else-if="logoutLink" class="lg:inline-flex lg:w-auto px-3 py-2 text-3xl text-white tracking-most-widest hover:text-fa-secondary cursor-pointer" @click="logout">
        <slot></slot>
    </div>
    <div v-else class="lg:inline-flex lg:w-auto px-3 py-2 text-3xl text-white tracking-most-widest hover:text-fa-secondary cursor-pointer">
        <slot></slot>
    </div>
</template>
<script>
import { computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useStore } from 'vuex';
export default {
    props:{
        to: String,
        active: Boolean,
        logoutLink: Boolean
    },
    setup(props) {
        const route = useRoute();
        const router = useRouter();
        const store = useStore();

        const underlineClass = 'underline underline-offset-8 text-fa-secondary';

        const isActive = computed(() => {
            return route.path == props.to;
        });

        async function logout(){
            store.commit('toggleLoading');
            const response = await store.dispatch('auth/logout');
            router.replace('/login');
            store.commit('toggleLoading');
        }

        return {
            underlineClass,
            isActive,
            logout
        }
    }
}
</script>
