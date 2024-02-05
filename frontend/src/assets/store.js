// store/index.js

import { createStore } from 'vuex';

export default createStore({
  state: {
    token: null,
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
    },
  },
  // actions, getters akan ditambahkan di sini
});
