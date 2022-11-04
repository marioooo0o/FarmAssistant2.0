import axios from "axios";

export default {
    async loadWarehouse(context, payload){
        if(!context.getters.shouldUpdateWarehouse){
            return;
        }
        const warehouseId = context.getters.userMagazine.id;
        await axios
        .get(`warehouses/${warehouseId}`)
        .then(function (res){
            if(res.status === 200){
                const products = [];
                res.data.warehouse.data.forEach(element => {
                    const product = {
                        id: element.id,
                        name: element.name,
                        permit_number: element.permit_number,
                        permit_deadline: element.permit_deadline,
                        sale_deadline: element.sale_deadline,
                        term_for_use: element.term_for_use,
                        type: element.type,
                        active_substance: element.active_substance,
                        plant:  element.plant,
                        pest:   element.pest,
                        dose:   element.dose,
                        recommended_dose: element.recommended_dose,
                        maximum_dose: element.maximum_dose,
                        unit: element.unit,
                        deadline: element.deadline,
                        group_name: element.group_name,
                        small_area: element.small_area,
                        application: element.application,
                        pivot: element.pivot,
                    };
                    products.push(product);
                });
                console.log('products', products);
                context.commit('setProducts', products);
                context.commit('setFetchTimestampWarehouse');
                if(res.data.warehouse.next_page_url){
                    const nextPageUrlArray = res.data.warehouse.next_page_url.split('/').slice(4);
                    context.commit('setNextPaginationPageUrl', `${nextPageUrlArray[0]}/${nextPageUrlArray[1]}`);
                }
                else {
                        context.commit('setNextPaginationPageUrl', null);
                }
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
        })

    },

    async loadNextProducts(context, payload){
        const url = context.getters['getNextPaginationPageUrl'];
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
                const products = [];
                res.data.warehouse.data.forEach(element => {
                    const product = {
                        id: element.id,
                        name: element.name,
                        permit_number: element.permit_number,
                        permit_deadline: element.permit_deadline,
                        sale_deadline: element.sale_deadline,
                        term_for_use: element.term_for_use,
                        type: element.type,
                        active_substance: element.active_substance,
                        plant:  element.plant,
                        pest:   element.pest,
                        dose:   element.dose,
                        recommended_dose: element.recommended_dose,
                        maximum_dose: element.maximum_dose,
                        unit: element.unit,
                        deadline: element.deadline,
                        group_name: element.group_name,
                        small_area: element.small_area,
                        application: element.application,
                        pivot: element.pivot,
                    };
                    products.push(product);
                });
                context.commit('addProducts', products);
                context.commit('setFetchTimestampWarehouse');
                if(res.data.warehouse.next_page_url){
                    const nextPageUrlArray = res.data.warehouse.next_page_url.split('/').slice(4);
                    context.commit('setNextPaginationPageUrl', `${nextPageUrlArray[0]}/${nextPageUrlArray[1]}`);
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
        }
        else{
            context.commit('response/setResponse', {
                            status: true,
                            message: 'Posiadasz już aktualne dane',
                    }, {root: true});
        }
    },
    async loadAllProducts(context, payload){
        if(!context.getters.shouldUpdatePlantProtectionProduct){
            return;
        }

        const response = await axios
        .get('plant-protection-products')
        .then(function (res){
            if(res.status === 200){
                const products = res.data.plant_protection_products;
                context.commit('setAllPlantProtecionProducts', {
                    allPlantProtectionProducts: products,
                });
                context.commit('response/setResponse', {
                        status: true,
                        message: 'Środki ochrony roślin pobrane!',
                }, {root: true});
                context.commit('setFetchTimestampPlantProtectionProduct');
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
    },
    async addProduct(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;

        const response = await axios
        .post(`farms/${farmId}/warehouses/products`, {
            ppp_id: payload.id,
            quantity: payload.quantity,
        })
        .then(function(res){
            if(res.status === 201){
                console.log('res', res);
                context.commit('setProducts', res.data.warehouse.products);
                context.commit('response/setResponse', {
                        status: true,
                        message: res.data.message,
                }, {root: true});

                return {
                    status: res.status,
                    statusText: res.statusText,
                }
            }
            else if(res.status === 422){
                const response = {
                    status: res.status,
                    statusText: res.statusText,
                    errors: res.data.errors
                }
                return response;
            }
        })
        .catch(function(err){
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
    async editProduct(context, payload){
        const farmId = context.rootGetters['farm/userFarm'].id;
        const productId = payload.productId;

        const response = await axios
        .put(`farms/${farmId}/warehouses/products/${productId}`, {
            ppp_id: payload.productId,
            quantity: payload.quantity,
        })
        .then(function(res){
            if(res.status === 200){
                context.commit('setProducts', {
                    products: res.data.warehouse.products
                });
                context.commit('response/setResponse', {
                        status: true,
                        message: 'Produkt edytowany pomyślnie!',
                }, {root: true});

                return {
                    status: res.status,
                    statusText: res.statusText,
                }
            }
            else if(res.status === 422){
                const response = {
                    status: res.status,
                    statusText: res.statusText,
                    errors: res.data.errors
                }
                return response;
            }
        })
        .catch(function(err){
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

    async getPlantProtectionProduct(context, payload){
        await axios
        .get(`plant-protection-products/${payload.productId}`)
        .then(function(res){
            console.log(res);
        })
        .catch(function(err){
            console.log('err', err);
        })
    }
}