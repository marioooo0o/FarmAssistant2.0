<template>
    <Navbar />
    <base-card> 
   <div class="flex flex-col lg:flex-row p-8 gap-8">
            <div class="px-2 py-4 min-w-[400px] self-top">
                <img src="@/assets/produkt.png" height="550" width="693" alt="Produkt">
            </div>
                 <div class="px-4 py-4">
                 <h1 class="text-4xl font-semibold tracking-wider pb-3">{{ product.name }}</h1> 
                <hr class="border-fa-primary w-1/2 pb-3">
                <p class=" tracking-wide">Virtus lab jest najlepszą firmą na świecie, a Filipiaka jebać prądem. 
                    Pozdrawiam serdecznie, jebać kapusi smacznej kawusi. Kolejną rzeczą jaką chcę powiedzieć o tym cudownym środku jest jego niezamowite oddziaływanie na środowisko. Jedynie łyżeczka tego środka i wszystkie ryby w Odrze wypierdala w kosmos. Sposób użycia to wciąganie nosem albo wcieranie w dziąsło.</p>
                <div class="flex justify-center font-extrabold tracking-wider text-lg py-3">Dawkowanie:<span class="text-fa-primary ml-3">50 ml / 1 ha</span> </div>
                <h2 class="text-lg font-extrabold tracking-wider pb-3">Szczegółowe informacje:</h2>
                <hr class="border-fa-primary w-1/2 pb-3">
                <section class="flex justify-between gap-2">
                    <div class="flex flex-wrap [&>*]:basis-[45%] w-1/2 gap-3" >
                        <div class="font-semibold " v-if="product.permit_number">Numer zezwolenia:</div>
                        <div v-if="product.permit_number">{{ product.permit_number }}</div> 
                        <div class="font-semibold" v-if="product.type">Rodzaj środka:</div>
                        <div v-if="product.type">{{ product.type }}</div>
                        <div class="font-semibold" v-if="product.active_substance">Substancja czynna z zawartością:</div>
                        <div v-if="product.active_substance">{{ product.active_substance }}</div> 
                        <div class="font-semibold" v-if="product.plant">Uprawa:</div>
                        <div v-if="product.plant">{{ product.plant }}</div> 
                        <div class="font-semibold" v-if="product.pest">Agrofag:</div>
                        <div v-if="product.pest">{{ product.pest}}</div> 
                    </div>
                    <div class="flex flex-wrap [&>*]:basis-[45%] w-1/2 gap-3">
                        <div class="font-semibold flex flex-wrap" v-if="product.dose">Dawkowanie:</div>
                        <div v-if="product.dose">{{ product.dose }}</div> 
                        <div class="font-semibold" v-if="product.deadline">Rodzaj środka:</div>
                        <div v-if="product.deadline">{{ product.deadline}}</div>
                    </div>
                </section>

                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div class="grid grid-cols-2">
                        
                    </div>
                    <div class="grid grid-cols-2">
                        
                    </div>
                </div>
            </div>
        </div> 
    </base-card>

</template>
<script>
import { ref, watch, computed } from 'vue'
import { useStore } from 'vuex';
import { onBeforeRouteUpdate, useRoute } from 'vue-router'
import Navbar from '../components/navbar/TheNavbar.vue';
export default {
    components: {
        Navbar
    },
    setup(props) {
        const route = useRoute();
        const store = useStore();
        onBeforeRouteUpdate((to, from) => {
            console.log('siema zmiena');
            console.log('to', to, 'from', from);
        })
        
        const product = computed(() =>{
            return store.getters['warehouses/allPlantProtectionProducts'].find(product => product.id === parseInt(route.params.id));
        });       
      
        return {
            product,
        }
    }
}
</script>
