import.meta.glob(["../images/**", "../fonts/**"]);
import alpine from "alpinejs";
Object.assign(window, { Alpine: alpine }).Alpine.start();
