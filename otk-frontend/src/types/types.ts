export type ActiveEvent = {
  id: number;
  created_at: string;
  updated_at: string;
  name: string;
  category_id: number;
  active: boolean;
  showRelatedDogs: boolean;
  registeredDogs: Dog[];
};

export type Category = {
  id: number;
  type: string;
  created_at: string;
  updated_at: string;
};

export type Dog = {
  id: number;
  created_at: string;
  updated_at: string;
  name: string;
  breed: string;
  gender: string;
  breed_id: number;
  hobby: number;
  birthdate: string;
  user_id: number;
  breederName: string;
  description: string;
  motherName: string;
  fatherName: string;
  registerSernum: string;
  herd_book_type_id: string;
  dog_class_id?: string | string[];
  type?: string;
};

export type User = {
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

export type Event = {
  active: number;
  category_id: number;
  created_at: string;
  id: number;
  name: string;
  updated_at: string;
};

export type RegisteredDogProfileData = {
  birthdate: string;
  originalRegisterSernum: string;
  dog: Dog;
  owner: User;
  isViewChanged: boolean;
  deleteConfirmDialogOptions: {
    value: string;
    title: string;
    confirmButton: string;
    cancelButton: string;
  };
  files: File[];
  registeredDog: any;
  errorMessage: string;
  errorDeleteMessage: string;
  successMessage: string;
  loaderActive: boolean;
  dogDataLoading: boolean;
  isDeleteLoading: boolean;
  rejectClicked: boolean;
  isAcceptOrRejectSubmitClicked: boolean;
  color: string;
  downIcon: any;
  upIcon: any;
  rejectReason: string;
  RegisteredDogStatus: typeof RegisteredDogStatus;
};

export type RegisteredDog = {
  created_at: string;
  updated_at: string;
  declined_reason: string | null;
  dog: Dog;
  dog_id: number;
  event: Event;
  event_category_id: 4;
  id: 1;
  status: string;
  user_id: number;
  isDeclinedButtonOpen: boolean,
};

export type File = {
  id: number;
  dog_id: number;
  generated_name: string;
  name: string;
  created_at: string;
  updated_at: string;
};

export enum RegisteredDogStatus {
  Approved,
  Declined,
  Paid,
  Pending,
}

export type HerdBookType = {
  id: number;
  type: string;
  created_at: string;
  updated_at: string;
};

export type BreedGroup = {
  id: number;
  name: string;
  herd_book_type_id: number;
  created_at: string;
  updated_at: string;
  breeds: Breed[];
};

export type BreedGroupWithBreeds = {
  id: number;
  name: string;
  herd_book_type_id: number;
  created_at: string;
  updated_at: string;
  breeds: Breed[];
};

export type Breed = {
  id: number;
  name: string;
  breed_group_id: number;
  created_at: string;
  updated_at: string;
};

export type BreedGroupData = {
  id: number;
  name: string;
  isBreedGroupButtonOpen: boolean;
  herd_book_type_id: number;
  created_at: string | null;
  updated_at: string | null;
  dogCounterInBreedGroup: number;
  breeds: BreedData[];
  pivot: {
    breed_group_id: number;
    event_category_id: number;
  };
};

export type BreedData = {
  id: number;
  name: string;
  isBreedButtonOpen: boolean,
  breed_group_id: number;
  created_at: string | null;
  updated_at: string | null;
  dog_classes: DogClassData[];
  dogCounterInBreed: number;
};

export type DogClassData = {
  created_at: string | null;
  dogCounterInClass: number;
  isClassButtonOpen: boolean;
  id: number;
  range_end: number;
  range_start: number;
  registeredDogs: registeredDog[];
  type: string;
  updated_at: string | null;
};

export type registeredDog = {
  BreedGroupName: string;
  breedName: string;
  breed_group_id: number;
  breed_id: number;
  dog_class_id: number;
  id: number;
  name: string;
  type: string;
  email: string;
};

export type HerdBookTypeId = null | number;

export type Ring = {
  actualDog: any[];
  created_at: string;
  updated_at: string;
  exhibition_id: number;
  id: number;
  name: string;
}
export type Catalogue = {
  created_at: string;
  updated_at: string;
  exhibition_id: number;
  id: number;
  name: string;
}

export type SelectedDog = {
  BreedName: string;
  categoryType: string;
  classType: number;
  gender: number;
  hobbyCategoryType: string | null;
  id: number;
  selected: boolean;
  start_number: number | null;
}

export type Post = {
  content: string;
  created_at: string;
  updated_at: string;
  id: number;
  title: string;
}
