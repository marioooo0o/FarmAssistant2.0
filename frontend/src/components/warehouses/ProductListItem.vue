<template>
    <div class="bg-gray-300 font-semibold rounded-lg grid grid-cols-3 justify-center items-center text-xs box-border m-3 tracking-wider p-1 hover:ring-4">
        <div class="flex justify-center items-center"><RouterLink :to="productLink">{{product.name}}</RouterLink> </div>
        <div class="flex justify-center items-center"><ProductBar :quantity="product.pivot.quantity"/></div>
        <div class="flex justify-center items-center"><EditButton @click="$emit('edit-product', product)">Edytuj stan</EditButton></div>
    </div>
</template>
<script>
import { computed } from 'vue';
import ProductBar from './ProductBar.vue'
import EditButton from './EditButton.vue';
export default {
    components: {
        ProductBar,
        EditButton
    },
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    setup(props) {

        const productLink = computed(() => {
            return `/srodek-ochrony-roslin/${props.product.id}`;
        })
        
        return {
            productLink
        } 
    }
}
</script>
