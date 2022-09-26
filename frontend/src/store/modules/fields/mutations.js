export default {
    setFields(state, payload){
        state.userFields = payload;
    },
    addFields(state, payload){
        state.userFields = state.userFields.concat(payload);
    },
    addField(state, payload){
        state.userFields.push(payload);
    },
    editField(state, payload){
        const index = state.userFields.findIndex((field) => field.id === payload.id)
        state.userFields[index] = payload;
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
    setCrops(state, payload){
        state.allCrops = payload;
    },
    setCadastralParcels(state, payload){
        state.allParcels = payload;
    },
}