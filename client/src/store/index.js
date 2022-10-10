import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            role : window.localStorage.getItem("role") | null
        }
    },

    mutations : {
        setRole(state) {
            state.role = window.localStorage.getItem("role")
        }
    }
});

export default store;