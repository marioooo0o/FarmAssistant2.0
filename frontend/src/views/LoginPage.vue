<script>
import AuthHeader from "@/components/auth/AuthHeader.vue";
import LabelInput from "@/components/ui/LabelInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";

export default {
    components: {
        AuthHeader,
        LabelInput,
        BaseButton,
    },
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        handleClick() {
            console.log("CLICK");
        },
        handleSubmit() {
            console.log("Submit");
        },
    },
    watch: {
        email(newValue, oldValue) {
            console.log(newValue);
        },
        password(newValue, oldValue) {
            console.log(newValue);
        },
    },
};
</script>

<template>
    <AuthHeader border="right" />
    <main class="flex flex-col items-center">
        <form class="flex flex-col items-center gap-4 w-full" @submit="handleSubmit">
            <LabelInput auth id="email" label="Email" required v-model="email" type="email" />
            <LabelInput auth id="password" label="Hasło" required v-model="password" type="password" />
            <BaseButton class="mt-14 text-[36px]" @click="handleClick">Zaloguj</BaseButton>
        </form>
        <span class="text-3xl tracking-most-widest leading-15 mt-5">lub</span>
        <RouterLink
            class="font-semibold text-green-500 underline decoration-black leading-15 tracking-most-widest text-2xl underline-offset-8"
            to="/register">
            Stwórz nowe konto!
        </RouterLink>
    </main>
</template>
