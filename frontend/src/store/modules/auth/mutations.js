export default {
    setUserId(state, payload){
        state.userId = payload.userId;
    },
    setUserEmail(state, payload){
        state.userEmail = payload.email;
    },
    setUser(state, payload){
        state.userId = payload.userId;
        state.userEmail = payload.userEmail;
    },
    setAuth(state, payload){
        state.isAuth = true;
    },
    setUnauth(state, payload){
        state.isAuth = false;
    }
}