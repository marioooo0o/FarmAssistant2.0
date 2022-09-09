<template>
    <spinner v-if="isLoading"/>
    <div v-else class="grid grid-cols-2 h-full w-full">
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
    <ResponseModal v-if="responseObj.hasResponse" :success=responseObj.status :message=responseObj.message />
</template>
<script>
import { ref, reactive, computed, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router'
import { useStore } from 'vuex';
import AuthHeader from "@/components/auth/AuthHeader.vue";
import LabelInput from "@/components/ui/LabelInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import ResponseModal from '../components/ui/ResponseModal.vue';

export default {
    components: {
    AuthHeader,
    LabelInput,
    BaseButton,
    ResponseModal
},
    emits: ['submit-form'],
    setup(props, { emit }){
        const store = useStore();
        const router = useRouter();
        const route = useRoute();
    
        const isLoading = computed(() => {
            return store.getters.isLoading;
        })

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
                if(password.value.length < 6){
                    errors.password.push("Hasło musi zawierać minimum 6 znaków");
                }
            }
        });

        watch(passwordConfirmation, (newValue) =>{
            if(saveFirstClicked.value){
                errors.passwordConfirmation = [];
                if(newValue === ""){
                    errors.passwordConfirmation.push("Hasło jest wymagane");
                }
                if(passwordConfirmation.value.length < 6){
                    errors.passwordConfirmation.push("Hasło musi zawierać minimum 6 znaków");
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

        async function submitForm() {
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                store.commit('toggleLoading');
                const formData = {
                    email: email.value,
                    password: password.value,
                    password_confirmation: passwordConfirmation.value,
                }
                const response = await store.dispatch('auth/register', formData);
                store.commit('toggleLoading');
                if(response.status === 422){
                    for (let e in response.errors){
                        switch(e){
                            case "email":{
                                errors.email.push(...response.errors[e]);
                                break;
                            }
                            case "password":{
                                errors.password.push(...response.errors[e]);
                                errors.passwordConfirmation.push(...response.errors['password']);
                                break;
                            }
                        }
                    }
                }
                if(response.status === 201){
                    router.push({name: 'login'});
                }
                console.log('response', response);
            }

        }

        const responseObj = computed(() => {
                return store.getters['response/getResponse'];
            });

        return {
            isLoading,
            email,
            password,
            passwordConfirmation,
            errors,
            submitForm,
            responseObj
        }
    }
};
</script>
