export default {
    allCrops(state){
        return state.allCrops;
    },
    allParcels(state){
        return state.allParcels;
    },
    userFields(state){
        return state.userFields;
    },
    allUserFields(state){
        return state.allUserFields;
    },
    shouldUpdate(state){
        const lastFetch = state.lastFetch;
        if(!lastFetch){
            return true;
        }
        const currentTimeStamp = new Date().getTime();
        return (currentTimeStamp - lastFetch) / 1000 > 60*5;
    },
    shouldUpdateAllUserFields(state){
        const lastFetch = state.lastFetchAllUserFields;
        if(!lastFetch){
            return true;
        }
        const currentTimeStamp = new Date().getTime();
        return (currentTimeStamp - lastFetch) / 1000 > 60*5;

    },
    getNextPaginationPageUrl(state){
        return state.nextPaginationPageUrl;
    }
}