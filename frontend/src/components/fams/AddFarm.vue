<template>
    <base-description-card saveIcon
    formName="farmForm" >
        <div class="flex flex-col items-center font-semibold tracking-wider px-16">
            <h1 class="text-2xl">Dodaj Gospodarstwo</h1>
            <form id="farmForm" @submit.prevent="submitForm">
                <base-form-control>
                    <base-label id="farmName" label="Nazwa gospodarstwa:" v-model="farmName" type="text" :error="errors['farmName']"></base-label>
                </base-form-control>
                <base-form-control>
                    <base-label id="streetName" label="Ulica" v-model="streetName" type="text" :error="errors['streetName']"></base-label>
                </base-form-control>
                <base-form-control>
                    <base-label id="streetNumber" label="Numer domu:" v-model="streetNumber" type="text" :error="errors['streetNumber']"></base-label>
                </base-form-control>
                <base-form-control>
                    <base-label id="postalCode" label="Kod pocztowy:" v-model="postalCode" type="text" :error="errors['postalCode']"></base-label>
                </base-form-control>
                <base-form-control>
                    <base-label id="cityName" label="Miejscowość:" v-model="cityName" type="text" :error="errors['cityName']"></base-label>
                </base-form-control>
            </form>
        </div>
    </base-description-card>
</template>
<script>
import { ref, reactive, watch } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
export default {
    setup(props){
        const store = useStore();
        const router = useRouter();

        const farmName = ref('');
        const streetName = ref('');
        const streetNumber = ref('');
        const postalCode = ref('');
        const cityName = ref('');

        const errors = reactive({
            farmName: [],
            streetName: [],
            streetNumber: [],
            postalCode: [],
            cityName: [],
        });

        const saveFirstClicked = ref(false);
        watch(farmName, (newValue) => {
            if(saveFirstClicked.value){
                errors.farmName = [];
                if(newValue === null){
                    errors.farmName.push("Nazwa gospodarstwa jest wymagana");
                }
            }
        });

        watch(streetName, (newValue) => {
            if(saveFirstClicked.value){
                errors.streetName = [];
                if(newValue === null){
                    errors.streetName.push("Ulica jest wymagana");
                }
            }
        });

        watch(streetNumber, (newValue) => {
            if(saveFirstClicked.value){
                errors.streetNumber = [];
                if(newValue === null){
                    errors.streetNumber.push("Numer domu jest wymagany");
                }
            }
        });

        watch(postalCode, (newValue) => {
            if(saveFirstClicked.value){
                errors.postalCode = [];
                if(newValue === null){
                    errors.postalCode.push("Kod pocztowy jest wymagany");
                }
            }
        });

        watch(cityName, (newValue) => {
            if(saveFirstClicked.value){
                errors.cityName = [];
                if(newValue === null){
                    errors.cityName.push("Miejscowość jest wymagana");
                }
            }
        });

        function checkForm(){
            errors.farmName = [];
            errors.streetName = [];
            errors.streetNumber = [];
            errors.postalCode = [];
            errors.cityName = [];

            if(farmName.value && streetName.value && streetNumber.value && postalCode.value && cityName.value){
                return true;
            }

            if(!farmName.value){
                errors.farmName.push("Nazwa gospodarstwa jest wymagana");
            }
            if(!streetName.value){
                errors.streetName.push("Ulica jest wymagana");
            }
            if(!streetNumber.value){
                errors.streetNumber.push("Numer domu jest wymagany");
            }
            if(!postalCode.value){
                errors.postalCode.push("Kod pocztowy jest wymagany");
            }
            if(!cityName.value){
                errors.cityName.push("Miejscowość jest wymagana");
            }
            return false;
        }

        async function submitForm(){
            if(!saveFirstClicked.value) saveFirstClicked.value = true;
            if(checkForm()){
                store.commit('toggleLoading');
                const formData = {
                    name: farmName.value,
                    street: streetName.value,
                    street_number: streetNumber.value,
                    postal_code: postalCode.value,
                    city: cityName.value,
                };
                const response = await store.dispatch('farm/addNewFarm', formData)
                store.commit('toggleLoading');
                if(response.status === 422){
                    for(let e in response.errors){
                        switch(e){
                            case "name": {
                                errors.farmName.push(...response.errors[e]);
                                break;
                            }
                            case 'street': {
                                errors.streetName.push(...response.errors[e]);
                                break;
                            }
                            case 'street_number':{
                                errors.streetNumber.push(...response.errors[e]);
                                break;
                            } 
                            case 'postal_code': {
                                errors.postalCode.push(...response.errors[e]);
                                break;
                            }
                            case 'city': {
                                errors.cityName.push(...response.errors[e]);
                                break;
                            }
                        }
                    }
                }
                else if(response.status === 401){
                    router.replace('/login')
                }
            }
        }
        return {
            farmName,
            streetName,
            streetNumber,
            postalCode,
            cityName,
            errors,
            submitForm
        }
    }
}
</script>
