export default {
    setWarehouse(state, payload){
        state.warehouse.id = payload.id;
        state.warehouse.farmId = payload.farmId;
    },
    setProducts(state, payload){
        state.warehouse.products = payload.products;
    },
    setAllPlantProtecionProducts(state, payload){
        state.allPlantProtectionProducts = payload.allPlantProtectionProducts;
    },
}