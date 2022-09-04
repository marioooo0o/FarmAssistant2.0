import { createStore } from "vuex";

import fieldsModule from './modules/fields/index.js';
import warehousesModule from './modules/warehouses/index.js'
const store = createStore({
    state(){
        return {}
    },
    mutations: {

    },
    getters:{

    },
    modules: {
        fields: fieldsModule,
        warehouses: warehousesModule,
    },

});

export default store;