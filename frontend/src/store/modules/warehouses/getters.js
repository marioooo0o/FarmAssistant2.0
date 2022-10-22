export default {
    userMagazine(state){
        return state.warehouse;
    },
    warehouseProducts(state){
        return state.warehouse.products.filter((product) => product.pivot.quantity > 0);
    },
    allPlantProtectionProducts(state){
        return state.allPlantProtectionProducts;
    },
    getNextPaginationPageUrl(state){
        return state.nextPaginationPageUrl;
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