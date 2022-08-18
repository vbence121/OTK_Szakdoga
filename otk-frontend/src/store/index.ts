import { createStore } from 'vuex';

type UserData = {
  company: number,
  created_at: string,
  email: string,
  email_verified_at: string | undefined,
  updated_at: string,
  id: number,
  name: string,
  phone: string,
  user_type: number,
  username: string,
}

interface RootState {
  isRegistered: boolean,
  isUserLoggedIn: boolean,
  isAdminLoggedIn: boolean,
  isJudgeLoggedIn: boolean,
  user: {
    email: string,
  },
  userData: UserData | undefined,
  myDogs: [],
  isDogsLoaded: boolean,
  isUserLoaded: boolean,
}

const state: RootState = {
  isRegistered: false,
  isUserLoggedIn: false,
  isAdminLoggedIn: false,
  isJudgeLoggedIn: false,
  user: {
    email: '',
  },
  userData: undefined,
  myDogs: [],
  isDogsLoaded: false,
  isUserLoaded: false,
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
    },
    getUserData(state): UserData | undefined {
      return state.userData;
    },
    getIsUserLoaded(state): boolean {
      return state.isUserLoaded;
    },
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
    setUserData(state, userData: UserData) {
      state.userData = userData;
    },
    setIsDogsLoaded(state, isDogsLoaded: boolean) {
      state.isDogsLoaded = isDogsLoaded;
    },
    setIsUserLoaded(state, isUserLoaded: boolean) {
      state.isUserLoaded = isUserLoaded;
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
    setUserData(context, payload: { userData: UserData }) {
      context.commit("setUserData", payload.userData);
    },
    setIsUserLoaded(context, payload: {isUserLoaded: boolean}) {
      context.commit("setIsUserLoaded", payload.isUserLoaded);
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
