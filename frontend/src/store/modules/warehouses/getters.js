export default {
    userMagazine(state){
        return state.warehouse;
    },
    warehouseProducts(state){
        console.log(state.warehouse.products.filter((product) => product.pivot.quantity > 0));
        return state.warehouse.products.filter((product) => product.pivot.quantity > 0);
    },
    allPlantProtectionProducts(state){
        return state.allPlantProtectionProducts;
    },
    shouldUpdateWarehouse(state){
        const lastFetch = state.lastFetch.lastFetchWarehouse;
        if(!lastFetch){
            return true;
        }
        const currentTimeStamp = new Date().getTime();
        return (currentTimeStamp - lastFetch) / 1000 > 60*5;
    },
    shouldUpdatePlantProtectionProduct(state){
        const lastFetch = state.lastFetch.lastFetchPlantProtectionProduct;
        if(!lastFetch){
            return true;
        }
        const currentTimeStamp = new Date().getTime();
        return (currentTimeStamp - lastFetch) / 1000 > 60*5;
    }
}