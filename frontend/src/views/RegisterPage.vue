<template>
    <div class="grid grid-cols-2 h-full w-full">
        <main class="flex flex-col items-center justify-center">
            <form class="flex flex-col items-center gap-3 w-full" @submit.prevent="submitForm">
                <LabelInput auth id="email" label="Email:" v-model.trim="email" type="email"
                :error="errors['email']" />
                <LabelInput auth id="password" label="Hasło:" v-model.trim="password" type="password"
                :error="errors['password']" />
                <LabelInput auth id="passwordConfirmation" label="Powtórz hasło:" v-model.trim="passwordConfirmation" type="password" 
                :error="errors['passwordConfirmation']" />
                <BaseButton class="mt-14 text-3xl" type="submit">Zarejestruj</BaseButton>
            </form>
            <span class="text-2xl tracking-most-widest leading-15 mt-5">lub</span>
            <RouterLink
                class="font-semibold text-green-500 underline decoration-black leading-15 tracking-most-widest text-xl underline-offset-8"
                to="/login">
                Zaloguj się na istniejące konto
            </RouterLink>
        </main>
        <AuthHeader border="left" />
    </div>
</template>
<script>
import { ref, reactive, watch } from 'vue'
import AuthHeader from "@/components/auth/AuthHeader.vue";
import LabelInput from "@/components/ui/LabelInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";

export default {
    components: {
        AuthHeader,
        LabelInput,
        BaseButton,
    },
    emits: ['submit-form'],
    setup(props, { emit }){
        const email = ref('');
        const password = ref('');
        const passwordConfirmation = ref('');

        const errors = reactive({
            email: [],
            password: [],
            passwordConfirmation: [],
        });

        const saveFirstClicked = ref(false);

        watch(email, (newValue) =>{
            if(saveFirstClicked.value){
                errors.email = [];
                if(newValue === ""){
                    errors.email.push("Email jest wymagany");
                }
            }
        });

        watch(password, (newValue) =>{
            if(saveFirstClicked.value){
                errors.password = [];
                if(newValue === ""){
                    errors.password.push("Hasło jest wymagane");
                }
            }
        });

        watch(passwordConfirmation, (newValue) =>{
            if(saveFirstClicked.value){
                errors.passwordConfirmation = [];
                if(newValue === ""){
                    errors.passwordConfirmation.push("Hasło jest wymagane");
                    }
            }
        });

        function checkForm(){
            errors.email = [];
            errors.password = [];
            errors.passwordConfirmation = [];
            if(email.value && password.value && passwordConfirmation.value && password.value === passwordConfirmation.value){
                return true;
            }
            if(!email.value){
                errors.email.push("Email jest wymagany");
            }
            if(!password.value){
                errors.password.push("Hasło jest wymagane");
            }
            if(!passwordConfirmation.value){
                errors.passwordConfirmation.push("Hasło jest wymagane");
            }
            if(password.value !== passwordConfirmation.value){
                errors.password.push("Hasła muszą być identyczne");
                errors.passwordConfirmation.push("Hasła muszą być identyczne");
            }
            return false;
        }

        function submitForm() {
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    email: email.value,
                    password: password.value,
                    password_confirmation: passwordConfirmation.value,
                }
                console.log('formData', formData);
                emit('submit-form', formData);
            }
        }

        return {
            email,
            password,
            passwordConfirmation,
            errors,
            submitForm
        }
    }
};
</script>
