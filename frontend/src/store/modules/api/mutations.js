export default {
    setResponse(state, payload){
        state.response.hasResponse = true;
        state.response.status = payload.status;
        state.response.message = payload.message;

        setTimeout(() => {
                state.response.hasResponse = false;
                state.response.status = null;
                state.response.message = "";
            }, 2000);
    },
    closeResponse(state){
        state.response.hasResponse = false;
        state.response.status = null;
        state.response.message = "";
    }
}