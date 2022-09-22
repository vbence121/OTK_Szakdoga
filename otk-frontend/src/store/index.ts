import { BreedGroupWithBreeds, Dog, HerdBookType } from "@/types/types";
import axios from "axios";
import { createStore } from "vuex";

type UserData = {
  company: number;
  created_at: string;
  email: string;
  email_verified_at: string | undefined;
  updated_at: string;
  id: number;
  name: string;
  phone: string;
  user_type: number;
  username: string;
};

interface RootState {
  isRegistered: boolean;
  isUserLoggedIn: boolean;
  isAdminLoggedIn: boolean;
  isJudgeLoggedIn: boolean;
  user: {
    email: string;
  };
  userData: UserData | undefined;
  myDogs: [];
  myActiveEvents: [];
  categories: [];
  hobbyCategories: [];
  isDogsLoaded: boolean;
  isUserLoaded: boolean;
  isActiveEventsLoaded: boolean;
  lastOpenedId: {
    name: string;
    event: any;
    id: number;
    comesFromPayments: boolean;
  };
  lastOpenedDog: Dog;
  herdBookTypes: HerdBookType[];
  breedGroupsWithBreeds: BreedGroupWithBreeds[],
}

const state: RootState = {
  isRegistered: false,
  isUserLoggedIn: false,
  isAdminLoggedIn: false,
  isJudgeLoggedIn: false,
  user: {
    email: "",
  },
  userData: undefined,
  myDogs: [],
  myActiveEvents: [],
  categories: [],
  hobbyCategories: [],
  isDogsLoaded: false,
  isUserLoaded: false,
  isActiveEventsLoaded: false,
  lastOpenedId: {
    name: "",
    event: {},
    id: -1,
    comesFromPayments: false,
  },
  lastOpenedDog: {} as Dog,
  herdBookTypes: [],
  breedGroupsWithBreeds: [],
};

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
    getHobbyCategories(state): any {
      return state.hobbyCategories;
    },
    getLastOpenedEventId(state): number {
      return state.lastOpenedId.id;
    },
    getLastOpenedEventName(state): any {
      return state.lastOpenedId.event;
    },
    getLastOpenedRegisteredDogDestination(state): boolean {
      return state.lastOpenedId.comesFromPayments;
    },

    // dogs
    getMyDogs(state): any {
      return state.myDogs;
    },
    getIsDogsLoaded(state): boolean {
      return state.isDogsLoaded;
    },
    getLastOpenedRegisteredDog(state): Dog {
      return state.lastOpenedDog;
    },
    getHerdBookTypes(state): HerdBookType[] {
      return state.herdBookTypes;
    },
    getBreedGroupsWithBreeds(state): BreedGroupWithBreeds[] {
      return state.breedGroupsWithBreeds;
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
    setHobbyCategories(state, categories: any) {
      state.hobbyCategories = categories;
    },
    setLastOpenedEventId(state, id: number) {
      state.lastOpenedId.id = id;
    },
    setLastOpenedEventName(state, name: any) {
      state.lastOpenedId.event = name;
    },
    setLastOpenedRegisteredDogDestination(state, comesFromPayments: boolean) {
      state.lastOpenedId.comesFromPayments = comesFromPayments;
    },

    // dogs
    setMyDogs(state, myDogs: any) {
      state.myDogs = myDogs;
    },
    setIsDogsLoaded(state, isDogsLoaded: boolean) {
      state.isDogsLoaded = isDogsLoaded;
    },
    setLastOpenedRegisteredDog(state, dog: Dog) {
      state.lastOpenedDog = dog;
    },
    setHerdBookTypes(state, herdBookTypes: HerdBookType[]) {
      state.herdBookTypes = herdBookTypes;
    },
    setBreedGroupsWithBreeds(state, breedGroupsWithBreeds: BreedGroupWithBreeds[]) {
      state.breedGroupsWithBreeds = breedGroupsWithBreeds;
    },
  },
  actions: {
    //users
    setIsRegistered(context, payload: { isRegistered: boolean }) {
      context.commit("setIsRegistered", payload.isRegistered);
    },
    setUserEmail(context, payload: { email: string; userType: number }) {
      context.commit("setUserEmail", payload.email);
      if (payload.userType === 1) context.commit("setIsUserLoggedIn", true);
      else if (payload.userType === 2)
        context.commit("setIsAdminLoggedIn", true);
      else if (payload.userType === 3)
        context.commit("setIsJudgeLoggedIn", true);
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
    setIsActiveEventsLoaded(
      context,
      payload: { isActiveEventsLoaded: boolean }
    ) {
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
            context.commit("setCategories", response.data.categories);
            context.commit("setHobbyCategories", response.data.hobbyCategories);
          }
        })
        .catch((error) => {
          console.error("There was an error!", error);
        });
    },
    setLastOpenedEventId(context, payload: { id: number }) {
      context.commit("setLastOpenedEventId", payload.id);
    },
    setLastOpenedEventName(context, payload: { name: any }) {
      context.commit("setLastOpenedEventName", payload.name);
    },

    //dogs
    setMyDogs(context, payload: { myDogs: any }) {
      context.commit("setMyDogs", payload.myDogs);
    },
    setIsDogsLoaded(context, payload: { isDogsLoaded: boolean }) {
      context.commit("setIsDogsLoaded", payload.isDogsLoaded);
    },
    setLastOpenedRegisteredDog(context, payload: { dog: Dog , comesFromPayments: boolean}) {
      context.commit("setLastOpenedRegisteredDog", payload.dog);
      context.commit("setLastOpenedRegisteredDogDestination", payload.comesFromPayments);
    },
    setDataForCreatingNewDog(context) {
      axios
        .get("http://localhost:8000/api/herdBookTypes/getHerdBookTypes", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          if (response.status !== undefined && response.status === 200) {
            console.log(response, "herdbooks");
            context.commit("setHerdBookTypes", response.data);
          }
        })
        .catch((error) => {
          console.error("There was an error!", error);
        });

      axios
        .get("http://localhost:8000/api/breedGroups/getBreedGroupsWithBreeds", {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          withCredentials: true,
        })
        .then((response) => {
          if (response.status !== undefined && response.status === 200) {
            console.log(response, "getBreedGroupsWithBreeds");
            context.commit("setBreedGroupsWithBreeds", response.data);
          }
        })
        .catch((error) => {
          console.error("There was an error!", error);
        });
    },
  },
  modules: {},
});
