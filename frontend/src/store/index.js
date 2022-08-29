import { createStore } from "vuex";

import fieldsModule from './modules/fields/index';
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
    },

});

export default store;