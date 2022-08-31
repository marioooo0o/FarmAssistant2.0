export default {
    setField(state, payload){
        state.userFields.push(payload.fieldData);
    }
}