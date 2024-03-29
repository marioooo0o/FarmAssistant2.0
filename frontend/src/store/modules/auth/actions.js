import axios from 'axios';

export default {
    async register(context, payload){
        const data = {
            email: payload.email,
            password: payload.password,
            password_confirmation: payload.password_confirmation,
        }
        const response = await axios
            .post('register', data)
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
                    context.commit('setUser',{
                        userId: res.data.user.id,
                        userEmail: res.data.user.email
                    });

                    context.commit('response/setResponse', {
                        status: res.data.success,
                        message: 'Użytkownik zarejestrowany pomyślnie'
                    }, {root: true})

                    const response = {
                        status: res.status,
                        statusText: res.statusText,
                    }
                    return response;
                }
            })
            .catch(function (err){
                alert(err);
            })
        return response;
    },

    async login(context, payload){
        const data = {
            email: payload.email,
            password: payload.password
        }
        const response = await axios
        .post('login', data)
        .then(function(res){
                if(res.status === 200){
                    localStorage.setItem('isAuth', true);
                    context.commit('setUser',{
                        userId: res.data.user.id,
                        userEmail: res.data.user.email
                    });
                    
                    if(res.data.user.farm){
                        context.commit('farm/setFarm',{
                            farmId: res.data.user.farm.id,
                            farmName: res.data.user.farm.name,
                            streetName: res.data.user.farm.street,
                            streetNumber: res.data.user.farm.street_number,
                            postalCode: res.data.user.farm.postal_code,
                            cityName: res.data.user.farm.city,
                            farmArea: res.data.user.farm.area,
                        }, {root: true})
                    }
                    const warehouse = res.data.user.warehouse;
                    if(warehouse){
                        context.commit('warehouses/setWarehouse', {
                            id: warehouse.id,
                            farmId: warehouse.farm_id
                        }, {root: true})
                    }
                    const response = {
                        status: res.status,
                        statusText: res.statusText,
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
                        statusText: res.statusText,
                    }
                    return response;
                }
                
            })
        .catch(function (err){
            console.log(err);
                const response ={
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
    },

    async loadUserProfile(context, payload){
        if(!context.rootGetters['farm/hasFarm']){
        const response =  await axios
            .get('user-profile')
            .then(function(res){
                if(res.status == 200){
                    context.commit('setUser',{
                        userId: res.data.user.id,
                        userEmail: res.data.user.email
                    });
                }
                if(res.data.user.farm){
                        context.commit('farm/setFarm',{
                            farmId: res.data.user.farm.id,
                            farmName: res.data.user.farm.name,
                            streetName: res.data.user.farm.street,
                            streetNumber: res.data.user.farm.street_number,
                            postalCode: res.data.user.farm.postal_code,
                            cityName: res.data.user.farm.city,
                            farmArea: res.data.user.farm.area,
                        }, {root: true})
                }
                const warehouse = res.data.user.warehouse;
                if(warehouse){
                    context.commit('warehouses/setWarehouse', {
                        id: warehouse.id,
                        farmId: warehouse.farm_id
                    }, {root: true})
                }
                const response = {
                        status: res.status,
                        statusText: res.statusText,
                }
                return response;
            })
            .catch(function(err){
                const response ={
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
        
    },
    async logout(context, payload){
        const response = await axios
        .get('logout')
        .then(function(res){
            context.commit('response/setResponse', {
                status: true,
                message: 'Użytkownik wylogowany pomyślnie',
            }, {root: true})

            const response = {
                status: res.status,
                statusText: res.statusText,
            }
            return response;
        })
        .catch(function(err){
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
}