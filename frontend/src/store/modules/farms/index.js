import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default{
    namespaced: true,
    state(){
        return {
            farmId: null,
            farmName: "",
            streetName: "",
            streetNumber: "",
            postalCode: "",
            cityName: "",
            farmArea: 0,
        }
    },
    getters,
    mutations,
    actions,
}