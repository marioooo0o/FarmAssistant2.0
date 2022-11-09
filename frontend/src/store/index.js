import { createStore } from "vuex";

import authModule from './modules/auth/index.js';
import responseModule from './modules/api/index.js';
import farmsModule from './modules/farms/index.js' 
import fieldsModule from './modules/fields/index.js';
import practisesModule from "./modules/practises/index.js";
import warehousesModule from './modules/warehouses/index.js';
const store = createStore({
    state(){
        return {
            loading: false,
        }
    },
    mutations: {
        toggleLoading(state){
            state.loading = !state.loading;
        }
    },
    getters:{
        isLoading(state){
            return state.loading;
        }
    },
    modules: {
        auth: authModule,
        response: responseModule,
        farm: farmsModule,
        fields: fieldsModule,
        practises: practisesModule,
        warehouses: warehousesModule,
    },

});

export default store;