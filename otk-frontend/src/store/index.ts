import { createStore } from 'vuex';

interface RootState {
  isRegistered: boolean,
  isLoggedIn: boolean,
  user: {
    email: string,
  },
  myDogs: [],
  isDogsLoaded: boolean,
}

const state: RootState = {
  isRegistered: false,
  isLoggedIn: false,
  user: {
    email: '',
  },
  myDogs: [],
  isDogsLoaded: false,
}

export default createStore({
  state: state,
  getters: {
    isRegistered(state): boolean {
      return state.isRegistered;
    },
    getUserEmail(state): string {
      return state.user.email;
    },
    isLoggedIn(state): boolean {
      return state.isLoggedIn;
    },
    getMyDogs(state): any {
      return state.myDogs;
    },
    getIsDogsLoaded(state): boolean {
      return state.isDogsLoaded;
    }
  },
  mutations: {
    setIsRegistered(state, isRegistered: boolean) {
      state.isRegistered = isRegistered;
    },
    setUserEmail(state, email: string) {
      state.user.email = email;
    },
    setIsLoggedIn(state, isLoggedIn: boolean) {
      state.isLoggedIn = isLoggedIn;
    },
    setMyDogs(state, myDogs: any) {
      state.myDogs = myDogs;
    },
    setIsDogsLoaded(state, isDogsLoaded: boolean) {
      state.isDogsLoaded = isDogsLoaded;
    },
  },
  actions: {
    setIsRegistered(context, payload: { isRegistered: boolean }) {
      context.commit("setIsRegistered", payload.isRegistered);
    },
    setUserEmail(context, payload: { email: string, isLoggedIn: boolean }) {
      context.commit("setUserEmail", payload.email);
      context.commit("setIsLoggedIn", payload.isLoggedIn);
    },
    setIsLoggedIn(context, payload: { isLoggedIn: boolean }) {
      context.commit("setIsLoggedIn", payload.isLoggedIn);
    },
    setMyDogs(context, payload: { myDogs: any }) {
      context.commit("setMyDogs", payload.myDogs);
    },
    setIsDogsLoaded(context, payload: {isDogsLoaded: boolean}) {
      context.commit("setIsDogsLoaded", payload.isDogsLoaded);
    },
  },
  modules: {
  }
})
