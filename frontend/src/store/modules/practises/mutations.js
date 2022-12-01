export default {
    setPractises(state, payload){
        state.userPractises = payload;
    },
    addPractises(state, payload){
        state.userPractises = state.userPractises.concat(payload);
    },
    addPractise(state, payload){
        state.userPractises.push(payload);
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