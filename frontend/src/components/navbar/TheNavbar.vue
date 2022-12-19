<template>
    <nav class="flex items-center bg-fa-primary p-3 flex-wrap fixed top-0 w-full lg:shadow-2xl shadow-green-300 z-10">
        <a href="" class="p-2 mr-4 inline-flex">
            <div class="flex items-center">
                <img src="../../assets/logoWithoutText.png" alt="Logo" height="60px" width="60px" class="w-10">
                <span class="text-3xl text-white tracking-most-widest ml-3">
                    <router-link to="/dashboard">FarmAssistant</router-link> 
                </span>
            </div>
        </a>
        <button class="text-white inline-flex p-3 hover:bg-gray-900 rounded lg:hidden ml-auto">
            <i class="material-icons">menu</i>
        </button>
        <div class="top-nav w-full lg:inline-flex lg:flex-grow lg:w-auto">
            <div class="lg:inline-flex lg:flex-row lg:ml-auto flex flex-col">
                <NavbarLink to="/dashboard">Home</NavbarLink>
                <NavbarLink to="/zabiegi-ochrony-roslin">Zabiegi</NavbarLink>
                <NavbarLink to="/grunty">Grunty</NavbarLink>
                <NavbarLink to="/magazyn">Magazyn</NavbarLink>
            </div>
        </div>
    </nav>
</template>
<script>
import { UserIcon } from '@heroicons/vue/outline';
import NavbarLink from './NavbarLink.vue'
export default {
    components:{
        NavbarLink, UserIcon
    },
    data(){
        return{
            activeIndex: 0
        }
    }
}
</script>