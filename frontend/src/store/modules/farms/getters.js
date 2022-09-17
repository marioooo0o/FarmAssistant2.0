export default {
    hasFarm(state){
        return state.farmId ? true : false;
    },
    userFarm(state){
        return {
            id: state.farmId,
            name: state.farmName,
            streetName: state.steetName,
            streetNumber: state.steetNumber,
            postalCode: state.postalCode,
            city: state.cityName,
        }
    }
}