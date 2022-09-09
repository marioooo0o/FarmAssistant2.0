import axios from 'axios';

export default {
    async register(context, payload){
        const url = "http://127.0.0.1:8000/api/register";
        console.log(context);
        const data = {
            email: payload.email,
            password: payload.password,
            password_confirmation: payload.password_confirmation,
        }
        const response = await axios
            .post(url, data, {
                headers: {
                    'Content-Type': 'application/json'
                },
                validateStatus: status => status >= 200 && status <300 || status === 422
            })
            .then(function(res){
                console.log('res w then',res);
                if(res.status === 422){
                    console.log('res w then',res);
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
                console.log('err', err);
                alert(err);
            })
        return response;
    }
}