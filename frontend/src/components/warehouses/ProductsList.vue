<template>
    <base-card>
        <div class="text-center font-semibold">
            <CardHeader title="Magazyn środków" addText="Dodaj środek"
            :headers="headers" :activeHeaderIndex="activeHeaderIndex"
            @add-new="$emit('show-create-page')" 
            @selected-header="sortHeader" />
            <div v-if="sortedList && sortedList.length > 0" class="p-3">
                <ProductListItem v-for="product in sortedList" :key="product.id" :product="product"
                    @edit-product="$emit('edit-product', $event)" />
            </div>
            <div v-else class="p-3 text-lg">
                Nie posiadasz żadnych środków
            </div>
            <base-button v-if="sortedList && sortedList.length > 5" :class="'m-3 text-lg'" @click="handleLoadMore">Załaduj więcej</base-button>
        </div>
    </base-card>
</template>
<script>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';
import { useRouter, useRoute } from 'vue-router';
import { mySort, sortAlphabetically, sortDescending } from '@/mylibs/sort.js';
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
        const store = useStore(); 
        const route = useRoute();
        const router = useRouter();

        const headers = [
            {
                id: 0,
                name: 'Nazwa środka',
                type: 'string',
                hoverIsAvaliable: true,
            },
            {
                id: 1,
                name: 'Poziom',
                type: 'number',
                hoverIsAvaliable: true,
            },
            {
                id: 2,
                name: '',
                hoverIsAvaliable: false,
            },
        ];

        const productsListFromProp = computed(() => {
            return props.productsList.length > 0 ? props.productsList : [];
        });
        
        const sortedList = computed(() => {
            switch (selectedHeader.value) {
                case 0:
                    if (isAsc.value) {
                        return mySort(productsListFromProp.value, (product) => product.name, sortAlphabetically);
                    }
                    else {
                        return mySort(productsListFromProp.value, (product) => product.name, sortDescending);
                    }
                    break;
                case 1:
                    if (isAsc.value) {
                        return mySort(productsListFromProp.value, (product) => product.pivot.quantity, sortAlphabetically);
                    }
                    else {
                        return mySort(productsListFromProp.value, (product) => product.pivot.quantity, sortDescending);
                    }
                    break;
                default:
                    return productsListFromProp.value;
            }
        });

        const activeHeaderIndex = ref(1);
        const prevIndex = ref(null);
        const isAsc = ref(true);
        const selectedHeader = ref(null);
        function sortHeader(headerId) {
            selectedHeader.value = headerId;
            activeHeaderIndex.value = headerId;
            if (activeHeaderIndex.value === prevIndex.value) {
                isAsc.value = !isAsc.value;
            } else {
                isAsc.value = true;
            }
            prevIndex.value = activeHeaderIndex.value;
        }

        async function handleLoadMore(){
            store.commit('toggleLoading');
            const response = await store.dispatch('warehouses/loadNextProducts');
            if (response && response.status === 401) {
                router.replace('/login');
            }
            store.commit('toggleLoading');
        }
        return {
            headers,
            activeHeaderIndex,
            sortHeader,
            handleLoadMore,
            sortedList
        }
    }
}
</script>
