import { createStore } from 'vuex'

interface RootState {
  isRegistered: boolean,
}

const state: RootState = {
  isRegistered: false,
}

export default createStore({
  state: state,
  getters: {
    isRegistered(state): boolean {
      return state.isRegistered;
    }
  },
  mutations: {
    setIsRegistered(state, isRegistered: boolean){
      state.isRegistered = isRegistered;
    }
  },
  actions: {
    setIsRegistered(context, payload: {isRegistered: boolean}){
      context.commit("setIsRegistered", payload.isRegistered);
    }
  },
  modules: {
  }
})
