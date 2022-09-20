import mutations from "./mutations.js";
import actions from "./actions.js";
import getters from "./getters.js";

export default {
    namespaced: true,
    state(){
        return {
            warehouse: {
                id: null,
                farmId: null,
                products: []
            },
            lastFetch:{
                lastFetchWarehouse: null,
                lastFetchPlantProtectionProduct: null
            },
            allPlantProtectionProducts: []
        }
    },
    mutations,
    actions,
    getters
}