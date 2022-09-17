<template>
    <base-card>
        <div class="text-center font-semibold">
            <CardHeader title="Magazyn środków" addText="Dodaj środek"
            :headers="headers" :activeHeaderIndex="activeHeaderIndex"
            @add-new="$emit('show-create-page')" 
            @selected-header="sortHeader" />
            <div v-if="productsList.length > 0" class="m-3">
                <ProductListItem v-for="product in productsList" :key="product.id" :product="product"
                    @edit-product="$emit('edit-product', $event)" />
            </div>
            <div v-else class="m-3 text-lg">
                Nie posiadasz żadnych środków
            </div>
            <base-button :class="'m-3 text-lg'">Załaduj więcej</base-button>
        </div>
    </base-card>
</template>
<script>
import { ref } from 'vue';
import CardHeader from '../ui/CardHeader.vue';
import ProductListItem from './ProductListItem.vue';
export default {
    components: {
        CardHeader,
        ProductListItem,
    },
    props: {
        productsList: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const headers = [
            {
                id: 0,
                name: 'Nazwa środka'
            },
            {
                id: 1,
                name: 'Poziom'
            },
            {
                id: 2,
                name: ''
            },
        ];

        const activeHeaderIndex = ref(0);
        
        function sortHeader(headerId){
            switch(headerId){
                case 0:
                    if(activeHeaderIndex === headerId){
                        props.fieldsList.sort((a, b) => a.name < b.name ? 1 : -1);
                    }
                    else{
                        props.fieldsList.sort((a, b) => a.name > b.name ? 1 : -1);
                    }
                    break;
                case 1:
                    props.fieldsList.sort((a,b)=> a.area > b.area ? 1: -1);
            }
            activeHeaderIndex.value = headerId;
        }
        return {
            headers,
            activeHeaderIndex,
            sortHeader
        }
    }
}
</script>
