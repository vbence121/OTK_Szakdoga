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

export enum RegisteredDogStatus {
    Approved,
    Declined,
    Paid,
    Pending,
}