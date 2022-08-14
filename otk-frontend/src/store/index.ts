import { createStore } from 'vuex';

interface RootState {
  isRegistered: boolean,
  isUserLoggedIn: boolean,
  isAdminLoggedIn: boolean,
  isJudgeLoggedIn: boolean,
  user: {
    email: string,
  },
  myDogs: [],
  isDogsLoaded: boolean,
}

const state: RootState = {
  isRegistered: false,
  isUserLoggedIn: false,
  isAdminLoggedIn: false,
  isJudgeLoggedIn: false,
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
    isUserLoggedIn(state): boolean {
      return state.isUserLoggedIn;
    },
    isAdminLoggedIn(state): boolean {
      return state.isAdminLoggedIn;
    },
    isJudgeLoggedIn(state): boolean {
      return state.isJudgeLoggedIn;
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
    setIsUserLoggedIn(state, isUserLoggedIn: boolean) {
      state.isUserLoggedIn = isUserLoggedIn;
    },
    setIsAdminLoggedIn(state, isAdminLoggedIn: boolean) {
      state.isAdminLoggedIn = isAdminLoggedIn;
    },
    setIsJudgeLoggedIn(state, isJudgeLoggedIn: boolean) {
      state.isJudgeLoggedIn = isJudgeLoggedIn;
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
    setUserEmail(context, payload: { email: string, userType: number }) {
      context.commit("setUserEmail", payload.email);
      if (payload.userType === 1) context.commit("setIsUserLoggedIn", true);
      else if (payload.userType === 2) context.commit("setIsAdminLoggedIn", true);
      else if (payload.userType === 3) context.commit("setIsJudgeLoggedIn", true);
    },
    setIsLoggedIn(context, payload: { isLoggedIn: boolean }) {
      context.commit("setIsUserLoggedIn", payload.isLoggedIn);
    },
    setMyDogs(context, payload: { myDogs: any }) {
      context.commit("setMyDogs", payload.myDogs);
    },
    setIsDogsLoaded(context, payload: {isDogsLoaded: boolean}) {
      context.commit("setIsDogsLoaded", payload.isDogsLoaded);
    },
    setAllUsersLoggedOut(context) {
      context.commit("setIsUserLoggedIn", false);
      context.commit("setIsAdminLoggedIn", false);
      context.commit("setIsJudgeLoggedIn", false);
      context.commit("setUserEmail", "");
      
    }
  },
  modules: {
  }
})
