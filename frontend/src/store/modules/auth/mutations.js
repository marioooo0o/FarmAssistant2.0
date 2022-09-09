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
    }
}