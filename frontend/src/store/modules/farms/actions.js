import axios from "axios";

export default {
    async addNewFarm(context, payload){
        const data = {
            name: payload.name,
            street: payload.street,
            street_number: payload.street_number,
            postal_code: payload.postal_code,
            city: payload.city,
        }

        const response = await axios
        .post('farms', data)
        .then(function(res){
                if(res.status === 422){
                    const response = {
                        status: res.status,
                        statusText: res.statusText,
                        errors: res.data.errors
                    }
                    return response;
                }
                else if(res.status === 201){
                    context.commit('setFarm', {
                        farmId: res.data.farm.id,
                        farmName: res.data.farm.name,
                        streetName: res.data.farm.street,
                        streetNumber: res.data.farm.street_number,
                        postalCode: res.data.farm.postal_code,
                        cityName: res.data.farm.city,
                        farmArea: res.data.farm.area,
                    });
                    
                    context.commit('response/setResponse', {
                        status: res.data.success,
                        message: res.data.message,
                    }, {root: true})

                    const response = {
                        status: res.status,
                        statusText: res.statusText,
                    }
                    return response;
                }
            })
        .catch(function (err){
                const response ={
                        status: err.response.status,
                        statusText: err.response.statusText,
                }
                context.commit('response/setResponse', {
                        status: false,
                        message: err.response.statusText,
                    }, {root: true});
                    return response;
            })
        return response;
    },

    async loadFarm(context, payload){
        const response = await axios
        .get(`farms/${payload.farmId}`)
        .then(function(res){
            console.log('res farm', res);
        })
        .catch(function (err){
            console.log('err farm', err);
        })

    }
}