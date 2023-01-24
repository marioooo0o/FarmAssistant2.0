export default {
    async loadPractises(context, payload){
        if (!context.getters.shouldUpdate){
            return;
        }
        const farmId = context.rootGetters['farm/userFarm'].id;

        const response = await axios
        .get(`farms/${farmId}/practises`)
        .then(function(res){
                if(res.status === 200){
                    const practises = [];
                    res.data.data.forEach(element => {
                        const practise = {
                            id: element.id,
                            farm_id: element.farm_id,
                            name: element.name,
                            start: element.start,
                            water: element.water,
                            fields: element.fields,
                            plant_protection_products: element.plant_protection_products,
                        };
                        practises.push(practise);
                    });
                    context.commit('setPractises', practises);
                    context.commit('setFetchTimestamp');
                    if(res.data.links.next){
                        const nextPageUrlArray = res.data.links.next.split('/').slice(4);
                        context.commit('setNextPaginationPageUrl', `${nextPageUrlArray[0]}/${nextPageUrlArray[1]}/${nextPageUrlArray[2]}`);
                    }
                    else {
                        context.commit('setNextPaginationPageUrl', null);
                    }
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

    async loadNextPractises(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;
        const url = context.getters['getNextPaginationPageUrl'];
        if(url){
            const response = await axios
            .get(url)
            .then(function(res){
                if(res.status === 200){
                    const practises = [];
                    res.data.data.forEach(element => {
                        const practise = {
                            id: element.id,
                            farm_id: element.farm_id,
                            name: element.name,
                            start: element.start,
                            water: element.water,
                            fields: element.fields,
                            plant_protection_products: element.plant_protection_products,
                        };
                        practises.push(practise);
                    });
                    context.commit('addPractises', practises);
                    context.commit('setFetchTimestamp');
                    if(res.data.links.next){
                        const nextPageUrlArray = res.data.links.next.split('/').slice(4);
                        context.commit('setNextPaginationPageUrl', `${nextPageUrlArray[0]}/${nextPageUrlArray[1]}/${nextPageUrlArray[2]}`);
                    }
                    else {
                        context.commit('setNextPaginationPageUrl', null);
                    }
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
                if(response.status === 401){
                    localStorage.removeItem('isAuth');
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
    async addPractise(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;

        const response = await axios
        .post(`farms/${farmId}/practises`, payload)
        .then(function(res){
            if(res.status === 201){
                const practise = {
                    id: res.data.practise.id,
                    farm_id: res.data.practise.farm_id,
                    name: res.data.practise.name,
                    start: res.data.practise.start,
                    water: res.data.practise.water,
                    fields: res.data.practise.fields,
                    plant_protection_products: res.data.practise.plant_protection_products,
                };
                context.commit('addPractise', practise);
                context.dispatch('warehouses/loadWarehouse', {}, {root: true });
                context.dispatch('warehouses/loadAllProducts', {}, {root: true });
                context.commit('response/setResponse', {
                    status: true,
                    message: "Zabieg dodany poprawnie",
                }, {root: true});

                const response = {
                    status: res.status,
                    success: res.data.success,
                    message: res.data.message,
                }
                return response;
            }
            else if(res.status == 422){
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
        .catch(function(err){
            console.log(err);
        })

        return response;
    },
    async editPractise(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;
        const practiseId = payload.practiseId;
        const url = `farms/${farmId}/practises/${practiseId}`;
        const response = await axios
        .put(url, payload)
        .then((res) => {
            if(res.status === 200){
                const practise = {
                    id: res.data.practise.id,
                    farm_id: res.data.practise.farm_id,
                    name: res.data.practise.name,
                    start: res.data.practise.start,
                    water: res.data.practise.water,
                    fields: res.data.practise.fields,
                    plant_protection_products: res.data.practise.plant_protection_products,
                };
                context.commit('editPractise', practise);
                const response = {
                    status: res.status,
                    statusText: res.statusText,
                }
                return response;
            }
            else if(res.status == 422){
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
                            statusText: res.statusText,
                        }
                return response;
            }
        })
        .catch((err) => {
            const response = {
                status: err.response.status,
                statusText: err.response.statusText,
            }
            if(err.response.status === 401){
                localStorage.removeItem('isAuth');
            }
            context.commit('response/setResponse', {
                status: false,
                message: err.response.statusText,
            }, {root: true});
            return response;
        })
        return response;
    },

    async deletePractise(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;
        const practiseId = payload.practiseId;
        const url = `farms/${farmId}/practises/${practiseId}`;

        const response = await axios
        .delete(url)
        .then(async function(res){
            if(res.status === 200){
                const response = {
                    status: res.status,
                    statusText: res.statusText,
                }
                context.commit('clearFetchTimestamp');
                await context.dispatch('loadPractises');

                return response;
            }
            else {
                const response = {
                            status: res.status,
                            statusText: res.statusText,
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
                localStorage.removeItem('isAuth');
            }
            context.commit('response/setResponse', {
                status: false,
                message: err.response.statusText,
            }, {root: true});
            return response;
        });

        return response;
    }
}