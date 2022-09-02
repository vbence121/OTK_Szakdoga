export type ActiveEvent = {
    id: number,
    created_at: string,
    updated_at: string,
    name: string,
    category_id: number,
    active: boolean,
    showRelatedDogs: boolean,
    registeredDogs: Dog[],
}

export type Dog = {
    id: number,
    created_at: string,
    updated_at: string,
    name: string,
    breed: string,
    hobby: number,
    birthdate: string,
    user_id: number,
    breederName: string,
    description: string,
    motherName: string,
    fatherName: string,
    category: string,
    registerSernum: string,
    registerType: string,
}

export type User = {
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

export type Event = {
    active: number,
    category_id: number,
    created_at: string,
    id: number,
    name: string,
    updated_at: string,
}

export type RegisteredDogProfileData = {
    birthdate: string,
    originalRegisterSernum: string,
    dog: Dog,
    owner: User,
    isViewChanged: boolean,
    deleteConfirmDialogOptions: {
        value: string,
        title: string,
        confirmButton: string,
        cancelButton: string,
    },
    errorMessage: string,
    errorDeleteMessage: string,
    successMessage: string,
    loaderActive: boolean,
    dogDataLoading: boolean,
    isDeleteLoading: boolean,
    rejectClicked: boolean,
    isAcceptOrRejectSubmitClicked: boolean,
    color: string,
    downIcon: any,
    upIcon: any,
    rejectReason: string,
    RegisteredDogStatus: typeof RegisteredDogStatus
}

export type RegisteredDog = {
    created_at: string,
    updated_at: string,
    declined_reason: string | null,
    dog: Dog,
    dog_id: number,
    event: Event,
    event_id: 4,
    id: 1,
    status: string,
    user_id: number,


}

export enum RegisteredDogStatus {
    Approved,
    Declined,
    Paid,
    Pending,
}