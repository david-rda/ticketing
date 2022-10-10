import { createStore } from "vuex";

const store = createStore({

    state : {
        role : window.localStorage.getItem("role") | null,
        token : window.localStorage.getItem("token") | null
    },

    mutations : {
        setRole(state) {
            state.role = window.localStorage.getItem("role")
        },

        setToken(state) {
            state.token = window.localStorage.getItem("token")
        }
    }
});

export default store;