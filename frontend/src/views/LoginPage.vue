<template>
    <div class="grid grid-cols-2 h-full w-full">
        <AuthHeader border="right" />
        <main class="flex flex-col items-center justify-center">
            <form class="flex flex-col items-center gap-3 w-full" @submit.prevent="submitForm">
                <LabelInput auth id="email" label="Email" v-model.trim="email" type="email" 
                :error="errors['email']"/>
                <LabelInput auth id="password" label="Hasło" v-model.trim="password" type="password"
                :error="errors['password']" />
                <BaseButton class="mt-14 text-3xl" type="submit">Zaloguj</BaseButton>
            </form>
            <span class="text-2xl tracking-most-widest leading-15 mt-5">lub</span>
            <RouterLink
                class="font-semibold text-green-500 underline decoration-black leading-15 tracking-most-widest text-xl underline-offset-8"
                to="/register">
                Stwórz nowe konto!
            </RouterLink>
        </main>
    </div>
</template>
<script>
import { ref, reactive, watch } from "vue";
import AuthHeader from "@/components/auth/AuthHeader.vue";
import LabelInput from "@/components/ui/LabelInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";

export default {
    components: {
        AuthHeader,
        LabelInput,
        BaseButton,
    },
    setup(props, { emit }){
        const email = ref("");
        const password = ref("");

        const errors = reactive({
            email: [],
            password: [],
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

        function checkForm(){
            errors.email = [];
            errors.password = [];
            if(email.value && password.value){
                return true;
            }

            if(!email.value){
                errors.email.push("Email jest wymagany");
            }
            if(!password.value){
                errors.password.push("Hasło jest wymagane");
            }
            return false;
        }

        function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                const formData = {
                    email: email.value,
                    password: password.value,
                }
                console.log('formData', formData);
                
            }
        }
        return {
            email,
            password,
            errors,  
            submitForm    
        }
    }
};
</script>
