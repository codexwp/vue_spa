import Vuex from 'vuex';

export const store = new Vuex.Store({
    state : {
        auth : JSON.parse(localStorage.getItem('auth')) || '',
        loading : false
    },
    mutations : {
        setAuth(state, auth){
            localStorage.setItem('auth', JSON.stringify(auth));
            state.auth = auth;
        },
        clearAuth(state){
            localStorage.removeItem('auth');
            state.auth = '';
        },
        loading(state, loading){
            state.loading = loading;
        }
    }
})