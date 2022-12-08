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
    editPractise(state, payload){
        const index = state.userPractises.findIndex((practise) => practise.id === payload.id);
        state.userPractises[index] = payload;
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