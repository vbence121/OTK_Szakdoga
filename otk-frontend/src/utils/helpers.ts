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

export function evaluateRegisteredDogStatusToHungarian(status: string): string {
    switch (status) {
        case 'approved': {
            return 'Jóváhagyva, nevezési díj nincs rendezve';
        }
        case 'declined': {
            return 'Visszautasítva';
        }
        case 'paid': {
            return 'Rendezve';
        }
        case 'pending': {
            return 'Folyamatban';
        }
        default: {
            return '';
        }
    }
}