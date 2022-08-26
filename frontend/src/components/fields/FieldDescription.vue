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
export default {
    props:{
        field:{
            type: Object,
            required: true
        }
    },
    emits: ['close-description-card', 'show-edit-page'],
    setup(props, { emit }) {
        function handleEditClicked() {
            console.log('edit clicked');
        };
        function handleDeleteClicked() {
            console.log('delete clicked');
        };
        function handleCloseCard(){
            emit('close-description-card');
        }
        return {
            handleEditClicked,
            handleDeleteClicked,
            handleCloseCard
        }
    },
}
</script>
