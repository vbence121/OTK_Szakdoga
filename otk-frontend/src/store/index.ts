import axios from 'axios';
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
  myActiveEvents: [],
  categories: [],
  isDogsLoaded: boolean,
  isUserLoaded: boolean,
  isActiveEventsLoaded: boolean,
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
  myActiveEvents: [],
  categories: [],
  isDogsLoaded: false,
  isUserLoaded: false,
  isActiveEventsLoaded: false,
}

export default createStore({
  state: state,
  getters: {
    // users
    isRegistered(state): boolean {
      return state.isRegistered;
    },
    getUserEmail(state): string {
      return state.user.email;
    },
    getUserData(state): UserData | undefined {
      return state.userData;
    },
    getIsUserLoaded(state): boolean {
      return state.isUserLoaded;
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

    // events
    getMyActiveEvents(state): any {
      return state.myActiveEvents;
    },
    getIsActiveEventsLoaded(state): any {
      return state.isActiveEventsLoaded;
    },
    getCategories(state): any {
      return state.categories;
    },

    // dogs
    getMyDogs(state): any {
      return state.myDogs;
    },
    getIsDogsLoaded(state): boolean {
      return state.isDogsLoaded;
    },
  },
  mutations: {
    // users
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
    setUserData(state, userData: UserData) {
      state.userData = userData;
    },
    setIsUserLoaded(state, isUserLoaded: boolean) {
      state.isUserLoaded = isUserLoaded;
    },

    // events
    setMyActiveEvents(state, myActiveEvents: any) {
      state.myActiveEvents = myActiveEvents;
    },
    setIsActiveEventsLoaded(state, isActiveEventsLoaded: any) {
      state.isActiveEventsLoaded = isActiveEventsLoaded;
    },
    setCategories(state, categories: any) {
      state.categories = categories;
    },

    // dogs
    setMyDogs(state, myDogs: any) {
      state.myDogs = myDogs;
    },
    setIsDogsLoaded(state, isDogsLoaded: boolean) {
      state.isDogsLoaded = isDogsLoaded;
    },
  },
  actions: {
    //users
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
    setUserData(context, payload: { userData: UserData }) {
      context.commit("setUserData", payload.userData);
    },
    setIsUserLoaded(context, payload: { isUserLoaded: boolean }) {
      context.commit("setIsUserLoaded", payload.isUserLoaded);
    },
    setAllUsersLoggedOut(context) {
      context.commit("setIsUserLoggedIn", false);
      context.commit("setIsAdminLoggedIn", false);
      context.commit("setIsJudgeLoggedIn", false);
      context.commit("setUserEmail", "");

    },

    // events
    setMyActiveEvents(context, payload: { myActiveEvents: any }) {
      context.commit("setMyActiveEvents", payload.myActiveEvents);
    },
    setIsActiveEventsLoaded(context, payload: { isActiveEventsLoaded: boolean }) {
      context.commit("setIsActiveEventsLoaded", payload.isActiveEventsLoaded);
    },
    setCategories(context) {
      axios
        .get("http://localhost:8000/api/categories/getCategories", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          if (response.status !== undefined && response.status === 200) {
            context.commit('setCategories', response.data);
          }
        })
        .catch((error) => {
          console.error("There was an error!", error);
        });
    },

    //dogs
    setMyDogs(context, payload: { myDogs: any }) {
    context.commit("setMyDogs", payload.myDogs);
  },
  setIsDogsLoaded(context, payload: { isDogsLoaded: boolean }) {
    context.commit("setIsDogsLoaded", payload.isDogsLoaded);
  },
},
  modules: {
}
})
