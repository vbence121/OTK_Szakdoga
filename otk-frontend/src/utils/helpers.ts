import { RegisteredDogStatus } from "@/types/types";
import store from "@/store";

export function evaluateRegisteredDogStatus(
  registeredDogStatus: RegisteredDogStatus
): string {
  switch (registeredDogStatus) {
    case 0: {
      return "approved";
    }
    case 1: {
      return "declined";
    }
    case 2: {
      return "paid";
    }
    case 3: {
      return "pending";
    }
    default: {
      return "";
    }
  }
}

export function evaluateRegisteredDogStatusToHungarian(status: string): string {
  switch (status) {
    case "approved": {
      return "Jóváhagyva, nevezési díj nincs rendezve";
    }
    case "declined": {
      return "Visszautasítva";
    }
    case "paid": {
      return "Rendezve";
    }
    case "pending": {
      return "Folyamatban";
    }
    default: {
      return "";
    }
  }
}

export function actualCategory(id: number): any {
  return store.getters.getCategories.find(
    (category: any) => category.id === id
  );
}

export function dateFormatter(date: string) {
  return date?.split("T")[0];
}

export function dateFormatterWhiteSpace(date: string) {
  return date?.split(" ")[0];
}
