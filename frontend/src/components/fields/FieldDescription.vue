<template>
    <base-description-card @close-description-card="handleCloseCard">
        <div class="font-semibold">
            <h1 class="flex justify-center items-center text-3xl">{{ field.field_name }}
                <span class="flex justify-center items-center ml-4 gap-2">
                    <i class="fa-regular fa-pen-to-square text-2xl cursor-pointer text-fa-primary hover:text-fa-secondary"
                        @click="$emit('show-edit-page')"></i>
                    <i class="fa-regular fa-trash-can text-2xl cursor-pointer text-fa-primary hover:text-red-500"
                        @click="handleDeleteClicked()"></i>
                </span>
            </h1>
            <div class=" flex flex-row items-center justify-between text-lg mt-12 gap-36">
                <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                    <div>Powierzchnia:</div>
                    <div>{{field.field_area}} ha</div>
                    <div>Działki:</div>
                    <div>
                        <ul>
                            <li v-for="parcel in field.cadastral_parcels" :key="parcel.id">Działka {{parcel.parcel_number}}</li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div>Uprawy:</div>
                    <div>
                        <img v-if="field.crop.image_path" :src="field.crop.image_path" :alt="field.crop.name" height="50px" width="50px" class="w-5" />
                        <span v-else>{{field.crop.name}}</span>
                    </div>
                </div>
            </div>
        </div>
    </base-description-card>
</template>
<script>
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';
export default {
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-description-card', 'show-edit-page'],
    setup(props, { emit }) {
        const store = useStore();
        const router = useRouter();

        async function handleDeleteClicked() {
            store.commit('toggleLoading');
            const response = await store.dispatch('fields/deleteField', {
                fieldId: props.field.id
            });
            if(response.status == 200) {
                store.commit('response/setResponse', {
                    status: true,
                    message: 'Pole usunięte pomyślnie!'
                }, { root: true });
                emit('close-description-card');
            }
            else if(response.status == 401){
                router.replace('/login');
            }
            store.commit('toggleLoading');
        };
        function handleCloseCard(){
            emit('close-description-card');
        }
        return {
            handleDeleteClicked,
            handleCloseCard
        }
    },
}
</script>
