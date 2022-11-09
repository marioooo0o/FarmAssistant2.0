export default {
    userPractises(state){
        return state.userPractises;
    },
    shouldUpdate(state){
        const lastFetch = state.lastFetch;
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