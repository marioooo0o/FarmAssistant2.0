import axios from "axios";

export default {
    async loadFields(context, payload){
        if (!context.getters.shouldUpdate){
            return;
        }
        const farmId = context.rootGetters['farm/userFarm'].id;
        const url = `http://127.0.0.1:8000/api/farms/${farmId}/fields`;

        const response = await axios
        .get(url, {
            withCredentials: true,
            headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json'
                },
        })
        .then(function(res){
                if(res.status === 200){
                    const fields = [];
                    res.data.fields.data.forEach(element => {
                        const field = {
                            id: element.id,
                            farm_id: element.farm_id,
                            field_name: element.field_name,
                            field_area: element.field_area,
                            cadastral_parcels: element.cadastral_parcels,
                            crop: element.crop,
                        };
                        fields.push(field);
                    });
                    context.commit('setFields', fields);
                    context.commit('setFetchTimestamp');
                    context.commit('setNextPaginationPageUrl', res.data.fields.next_page_url);
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

    async loadNextFields(context, payload){
        const url = context.getters['getNextPaginationPageUrl']
        if(url){
            const response = await axios
            .get(url, {
                withCredentials: true,
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(function(res){
                if(res.status === 200){
                    const fields = [];
                    res.data.fields.data.forEach(element => {
                        const field = {
                            id: element.id,
                            farm_id: element.farm_id,
                            field_name: element.field_name,
                            field_area: element.field_area,
                            cadastral_parcels: element.cadastral_parcels,
                            crop: element.crop,
                        };
                        fields.push(field);
                    });
                    context.commit('addFields', fields);
                    context.commit('setFetchTimestamp');
                    context.commit('setNextPaginationPageUrl', res.data.fields.next_page_url);
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
        }
        else{
            context.commit('response/setResponse', {
                            status: true,
                            message: 'Posiadasz już aktualne dane',
                    }, {root: true});
        }
        
    },
    async loadCrops(context, payload){
        if(context.getters['allCrops'].length === 0){
            const url = `http://127.0.0.1:8000/api/crops`;
            await axios
            .get(url, {
                withCredentials: true,
                headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json'
                    },
            })
            .then(function(res){
                    if(res.status === 200){
                        const crops = [];
                        res.data.crops.forEach(element => {
                            const crop = {
                                id: element.id,
                                name: element.name,
                                src: element.src,
                            };
                            crops.push(crop);
                        });
                        context.commit('setCrops', crops);
                    }
            })
            .catch(function (err){
                    context.commit('response/setResponse', {
                            status: false,
                            message: err.response.statusText,
                        }, {root: true});
                        return response;
            })
        }
    },
    async loadCadastralParcels(context, payload){
        if(context.getters['allParcels'].length === 0){
            const url = 'http://127.0.0.1:8000/api/cadastral-parcels';
            await axios
            .get(url, {
                withCredentials: true,
                headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json'
                    },
            })
            .then(function(res){
                    if(res.status === 200){
                        const parcels = [];
                        res.data.cadastral_parcels.forEach(element => {
                            const parcel = {
                                id: element.id,
                                parcel_number: element.parcel_number,
                                parcel_area: element.parcel_area,
                                fields: element.fields,
                                created_at: element.created_at,
                                updated_at: element.updated_at,
                                soil_Ph: element.soil_Ph,
                            };
                            parcels.push(parcel);
                        });
                        context.commit('setCadastralParcels', parcels);
                    }
            })
            .catch(function (err){
                    context.commit('response/setResponse', {
                            status: false,
                            message: err.response.statusText,
                        }, {root: true});
                        return response;
            })
        }
    },
    async addNewField(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;
        const url = `http://127.0.0.1:8000/api/farms/${farmId}/fields`;

        const response = await axios 
        .post(url, payload, {
                withCredentials: true,
                headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json'
                },
                validateStatus: status => status >= 200 && status <300 || status === 422
        })
        .then(function(res){
                    if(res.status === 201){
                        const field = {
                            id: res.data.field.id,
                            farm_id: res.data.field.farm_id,
                            field_name: res.data.field.field_name,
                            field_area: res.data.field.field_area,
                            cadastral_parcels: res.data.field.cadastral_parcel,
                            crop: res.data.field.crop,
                        }
                        context.commit('addField',  field);
                        const response = {
                            status: res.status,
                            success: res.data.success,
                            message: res.data.message,
                        }
                        return response;
                    }
                    else if(res.status === 422){
                        const response = {
                            status: res.status,
                            statusText: res.statusText,
                            errors: res.data.errors
                        }
                        return response;
                    }
                    else {
                        const response = {
                            status: res.status,
                            success: data.success,
                            message: data.message,
                        }
                        return response;
                    }
        })
        .catch(function (err){
            const response = {
                status: err.response.status,
                statusText: err.response.statusText,
            }
            if(err.response.status === 401){
                    return response;
            }else{
                    context.commit('response/setResponse', {
                        status: false,
                        message: err.response.statusText,
                    }, {root: true});
                    return response;
            }
        })
        return response;
    }
    
}