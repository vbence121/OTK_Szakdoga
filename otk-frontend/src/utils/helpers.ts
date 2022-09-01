import { RegisteredDogStatus } from "@/types/types";

export function evaluateRegisteredDogStatus(registeredDogStatus: RegisteredDogStatus): string {
    switch (registeredDogStatus) {
        case 0: {
            return 'approved';
        }
        case 1: {
            return 'declined';
        }
        case 2: {
            return 'paid';
        }
        case 3: {
            return 'pending';
        }
        default: {
            return '';
        }
    }
}