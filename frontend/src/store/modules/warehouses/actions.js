import axios from "axios";

export default {
    async loadWarehouse(context, payload){
        
        const warehouseId = context.getters.userMagazine.id;
        console.log(`warehouses/${warehouseId}`);
        const response = await axios
        .get(`warehouses/${warehouseId}`)
        .then(function (res){
            if(res.status === 200){
                context.commit('setProducts', {
                    products: res.data.warehouse.products
                });
            }
        })
        .catch(function (err){
            console.log(err);
        })

    },
    async loadAllProducts(context, payload){
        const response = await axios
        .get('plant-protection-products')
        .then(function (res){
            if(res.status === 200){
                const products = res.data.plant_protection_products;
                console.log('prod', products);
                context.commit('setAllPlantProtecionProducts', {
                    allPlantProtectionProducts: products,
                });
                context.commit('response/setResponse', {
                        status: true,
                        message: res.data.message,
                    }, {root: true});
            }
            console.log('res', res);
        })
        .catch(function (err){
            console.log(err);
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
                context.commit('setProducts', {
                    products: res.data.warehouse.products
                });
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
                context.commit('response/setResponse', {
                    status: false,
                    message: err.response.statusText,
                }, {root: true});
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
                context.commit('response/setResponse', {
                    status: false,
                    message: err.response.statusText,
                }, {root: true});
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