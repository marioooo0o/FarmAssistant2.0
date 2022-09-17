<template>
    <spinner v-if="isLoading" />
    <div v-else class="grid grid-cols-2 h-full w-full">
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
    <ResponseModal v-if="responseObj.hasResponse" :success=responseObj.status :message=responseObj.message />
</template>
<script>
import { ref, reactive, computed, watch } from "vue";
import AuthHeader from "@/components/auth/AuthHeader.vue";
import LabelInput from "@/components/ui/LabelInput.vue";
import BaseButton from "@/components/ui/BaseButton.vue";
import { useStore } from 'vuex';
import router from "../router";
import ResponseModal from "../components/ui/ResponseModal.vue";

export default {
    components: {
    AuthHeader,
    LabelInput,
    BaseButton,
    ResponseModal
},
    setup(props, { emit }){
        const store = useStore();
        const isLoading = computed(() => {
            return store.getters.isLoading;
        });

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

        async function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                store.commit('toggleLoading');
                const formData = {
                    email: email.value,
                    password: password.value,
                }
                const response = await store.dispatch('auth/login', formData)
                store.commit('toggleLoading');
                if(response.status === 200){
                    router.push({name: 'dashboard'});
                }
                else if(response.status === 401){
                    errors.email.push("Email lub hasło są niepoprawne");
                    errors.password.push("Email lub hasło są niepoprawne");
                }
                else if(response.status === 422){
                    for (let e in response.errors){
                        switch(e){
                            case "email":{
                                errors.email.push(...response.errors[e]);
                                break;
                            }
                            case "password":{
                                errors.password.push(...response.errors[e]);
                                break;
                            }
                        }
                    }
                }                
            }
        }

        const responseObj = computed(() => {
                return store.getters['response/getResponse'];
            });


        return {
            isLoading,
            email,
            password,
            errors,  
            submitForm,
            responseObj    
        }
    }
};
</script>
