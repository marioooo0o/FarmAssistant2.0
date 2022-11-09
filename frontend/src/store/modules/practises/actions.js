export default {
    async loadPractises(context, payload){
        console.log('loadPractises się zaczęło');
        if (!context.getters.shouldUpdate){
            return;
        }
        const farmId = context.rootGetters['farm/userFarm'].id;

        const response = await axios
        .get(`farms/${farmId}/practises`)
        .then(function(res){
            console.log('res', res);
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
                    console.log('wyjęte practises', practises);
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
            console.log('err', err);
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
    }
}