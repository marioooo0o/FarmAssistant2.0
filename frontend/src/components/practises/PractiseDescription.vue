<template>
    <base-description-card @close-description-card="handleCloseCard">
        <div class="font-semibold">
            <h1 class="flex justify-center items-center text-3xl">{{practise.name}}
                <span class="flex justify-center items-center ml-4 gap-2">
                    <i class="fa-regular fa-pen-to-square text-2xl cursor-pointer text-fa-primary hover:text-fa-secondary"
                        @click="handleEditClicked()"></i>
                    <!-- <i class="fa-regular fa-pen-to-square text-2xl cursor-pointer text-fa-primary hover:text-fa-secondary"
                        @click="$emit('show-edit-page')"></i> -->
                    <i class="fa-regular fa-trash-can text-2xl cursor-pointer text-fa-primary hover:text-red-500"
                        @click="handleDeleteClicked()"></i>
                </span>
            </h1>
            <div class=" flex flex-row items-center justify-between text-lg mt-12">
                <div class="grid grid-cols-4 gap-y-6 gap-x-6">
                    <div>Data wykonania:</div>
                    <div>{{ practise.start }}</div>
                    <div>Uprawy:</div>
                    <div>
                        <img v-for="crop in practiseCrops" :key="crop.id" :src="crop.image_path" :alt="crop.name" height="50px" width="50px"
                            class="w-5">
                    </div>
                    <div>Pola:</div>
                    <div>
                        <ul>
                            <li v-for="field in practise.fields" :key="field.id">Działka {{field.field_name}}</li>
                        </ul>
                    </div>
                    <div>Środki ochrony roślin:</div>
                    <div>
                        <ul>
                            <li v-for="product in practise.plant_protection_products" :key="product.id">{{ product.name}} {{product.pivot.quantity}} l</li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col">
                    
                </div>
            </div>
        </div>
    </base-description-card>
</template>
<script>
import { computed } from 'vue'
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';
export default {
    props:{
        practise:{
            type: Object,
            required: true
        }
    },
    emits: ['close-description-card', 'show-edit-page'],
    setup(props, { emit }) {
        const store = useStore();
        const router = useRouter();

        const practiseCrops = computed(() => {
            const map = {};
            for (const field of props.practise.fields) {
                if (!map[field.crop.image_path]) {
                    map[field.crop.image_path] = field.crop;
                }
            }
            return Object.values(map);
        });
        function handleEditClicked() {
            console.log('edit clicked', props.practise);
        };
        async function handleDeleteClicked() {
            console.log('delete practise clicked');
            // store.commit('toggleLoading');
            // const response = await store.dispatch('fields/deleteField', {
            //     fieldId: props.field.id
            // });
            // if(response.status == 200) {
            //     store.commit('response/setResponse', {
            //         status: true,
            //         message: 'Pole usunięte pomyślnie!'
            //     }, { root: true });
            //     emit('close-description-card');
            // }
            // else if(response.status == 401){
            //     router.replace('/login');
            // }
            // store.commit('toggleLoading');
        };
        function handleCloseCard(){
            emit('close-description-card');
        }
        return {
            practiseCrops,
            handleEditClicked,
            handleDeleteClicked,
            handleCloseCard
        }
    },
}
</script>
