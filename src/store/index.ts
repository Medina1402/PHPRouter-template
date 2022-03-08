import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from "@/services/Cookies";

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    _key: "feyri-labs-key",
    login: false
  },
  getters: {
    isLogged(state: any): boolean {
      let cookie = Cookies.get(state._key)
      state.login = cookie !== null
      return state.login
    }
  },
  mutations: {
    logging(state: any) {
      Cookies.set(state._key, "_Asda$%65as!@45asd", 7)
      state.login = true
    },

    logout(state: any) {
      Cookies.delete(state._key)
      state.login = false
    }
  },
  actions: {
  },
  modules: {
  }
})
