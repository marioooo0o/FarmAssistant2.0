<template>
    <base-description-card >
        <div class="my-4 font-semibold py-8 px-12">
            <h1 class="flex justify-center items-center text-3xl">Pole Romana
                <span class="flex ml-4 gap-2">
                    <PencilIcon class="h-7 w-7 cursor-pointer" @click="handleEditClicked()" />
                    <TrashIcon class="h-7 w-7 cursor-pointer" @click="handleDeleteClicked()" />
                </span>

            </h1>
            <div class=" flex flex-row items-center justify-between text-lg mt-12 mx-5 gap-12">
                <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                    <div>Powierzchnia:</div>
                    <div>11,00 ha</div>
                    <div>Działki:</div>
                    <div>
                        <ul>
                            <li>Działka 234</li>
                            <li>Działka 247</li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div>Uprawy:</div>
                    <div><img src="@/assets/crops/tomato.png" alt="tomato" height="50px" width="50px" class="w-5" />
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
    methods:{
        handleEditClicked(){
            console.log('edit clicked');
        },
        handleDeleteClicked(){
            console.log('delete clicked');
        }
    }
}
</script>
