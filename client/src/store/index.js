import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            role : window.localStorage.getItem("role") | 0
        }
    },

    mutations : {
        setRole(state) {
            state.role = window.localStorage.getItem("role")
        }
    }
});

export default store;