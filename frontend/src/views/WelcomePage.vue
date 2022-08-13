<template>
    <div class="absolute top-0 bottom-0 w-full h-full overflow-hidden">
        <video src="@/assets/intro.mp4" class="w-screen h-screen object-cover fixed inset-0 -z-[1]" autoplay loop muted>

        </video>
        <div class="flex flex-col my-3"></div>
        <AuthHeader />
        <div class="flex justify-around">

            <BaseButton link to="/login" :class="'text-[36px]'">Logowanie</BaseButton>
            <BaseButton link to="/register" :class="'text-[36px]'">Rejestracja</BaseButton>
        </div>
    </div>


</template>
<script>
import BaseButton from "../components/ui/BaseButton.vue";
import AuthHeader from "../components/auth/AuthHeader.vue" ;
                export default { components:{ BaseButton, AuthHeader } } </script>
