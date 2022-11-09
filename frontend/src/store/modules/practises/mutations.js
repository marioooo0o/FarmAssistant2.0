export default {
    setPractises(state, payload){
        state.userPractises = payload;
    },
    setFetchTimestamp(state){
        state.lastFetch = new Date().getTime();
    },
    clearFetchTimestamp(state){
        state.lastFetch = null;
    },
    setNextPaginationPageUrl(state, payload){
        state.nextPaginationPageUrl = payload;
    },
}