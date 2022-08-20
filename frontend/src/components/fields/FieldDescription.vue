<template>
    <base-description-card @close-description-card="$emit('close-description-card', $event)">
        <div class="my-4 font-semibold py-8 px-12">
            <h1 class="flex justify-center items-center text-3xl">{{ field.name }}
                <span class="flex ml-4 gap-2">
                    <PencilIcon class="h-7 w-7 cursor-pointer" @click="handleEditClicked()" />
                    <TrashIcon class="h-7 w-7 cursor-pointer" @click="handleDeleteClicked()" />
                </span>

            </h1>
            <div class=" flex flex-row items-center justify-between text-lg mt-12 mx-5 gap-12">
                <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                    <div>Powierzchnia:</div>
                    <div>{{field.area}} ha</div>
                    <div>Działki:</div>
                    <div>
                        <ul>
                            <li v-for="parcel in field.parcels" :key="parcel.id">Działka {{parcel.name}}</li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div>Uprawy:</div>
                    <div><img :src="field.crop.src" :alt="field.crop.alt" height="50px" width="50px" class="w-5" />
                    </div>
                </div>
            </div>
        </div>

    </base-description-card>



</template>
<script>
import { PencilIcon } from '@heroicons/vue/outline'
import { TrashIcon } from '@heroicons/vue/outline'
export default {
    components: {
        PencilIcon, TrashIcon
    },
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-description-card'],
    setup() {
        function handleEditClicked() {
            console.log('edit clicked');
        };

        function handleDeleteClicked() {
            console.log('delete clicked');
        };

        function closeCard(){
            console.log('otrzymano event w desc');
            $emit('closeDescriptionCard');
        }
        return {
            handleEditClicked,
            handleDeleteClicked,
            closeCard
        }
    },
}
</script>
