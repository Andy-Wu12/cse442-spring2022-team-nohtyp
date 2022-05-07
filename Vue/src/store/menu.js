import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default {
    namespaced: true,
    state: {
        open: false,
    },
    actions: {
        toggleMenu({commit, state}) {
            return commit('setOpen', !state.open);
        }
    },
    mutations: {
        setOpen(state, val){
            Vue.set(state, 'open', val);
        },
    }
}