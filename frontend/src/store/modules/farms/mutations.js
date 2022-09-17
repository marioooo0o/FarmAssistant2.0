export default {
    setFarm(state, payload){
        state.farmId = payload.farmId;
        state.farmName = payload.farmName;
        state.streetName = payload.streetName;
        state.streetNumber = payload.streetNumber;
        state.postalCode = payload.postalCode;
        state.cityName = payload.cityName;
        state.farmArea = payload.farmArea;
    }
}