export default {
    setWarehouse(state, payload){
        state.warehouse.id = payload.id;
        state.warehouse.farmId = payload.farmId;
    },
    setProducts(state, payload){
        state.warehouse.products = payload;
    },
    addProducts(state, payload){
        state.warehouse.products = state.warehouse.products.concat(payload);
    },
    setAllPlantProtecionProducts(state, payload){
        state.allPlantProtectionProducts = payload.allPlantProtectionProducts;
    },
    setFetchTimestampWarehouse(state){
        state.lastFetch.lastFetchWarehouse = new Date().getTime();
    },
    setFetchTimestampPlantProtectionProduct(state){
        state.lastFetch.lastFetchPlantProtectionProduct = new Date().getTime();
    },
    setNextPaginationPageUrl(state, payload){
        state.nextPaginationPageUrl = payload;
    },
}