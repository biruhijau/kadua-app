import Alpine from "alpinejs";
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

window.Alpine = Alpine;
window.Swal = Swal;

const accent = "#C89B3C";
const danger = "#dc2626";

/** Detect the active theme so alerts match the application. */
function isDark() {
    return document.documentElement.classList.contains("dark");
}

/** Shared SweetAlert2 theme options derived from the app palette. */
function theme() {
    const dark = isDark();

    return {
        background: dark ? "#0A0A0A" : "#ffffff",
        color: dark ? "rgba(255, 255, 255, 0.9)" : "rgba(0, 0, 0, 0.9)",
        confirmButtonColor: accent,
        cancelButtonColor: accent,
        customClass: {
            popup: "kadua-swal",
            confirmButton: "kadua-swal-confirm",
            cancelButton: "kadua-swal-cancel",
        },
    };
}

/**
 * Ask the user to confirm an action.
 *
 * @param {object} options
 * @param {string} [options.title]
 * @param {string} [options.text]
 * @param {string} [options.icon]
 * @param {string} [options.confirmText]
 * @param {string} [options.cancelText]
 * @param {boolean} [options.danger]
 * @returns {Promise<boolean>}
 */
window.confirmAction = async (options = {}) => {
    const {
        title = "",
        text = "",
        icon = "warning",
        confirmText = "Ya",
        cancelText = "Batal",
        danger: isDanger = false,
    } = options;

    const result = await Swal.fire({
        ...theme(),
        title,
        text,
        icon,
        showCancelButton: true,
        reverseButtons: true,
        focusCancel: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        confirmButtonColor: isDanger ? danger : accent,
    });

    return result.isConfirmed;
};

/**
 * Show a notification (success, error, warning, info) without auto-close.
 *
 * @param {string} type
 * @param {string} [title]
 * @param {string} [text]
 * @returns {Promise<unknown>}
 */
window.notify = (type, title = "", text = "") => {
    const icons = ["success", "error", "warning", "info"];
    const icon = icons.includes(type) ? type : "info";

    return Swal.fire({
        ...theme(),
        toast: false,
        icon,
        title,
        text,
        showConfirmButton: true,
        confirmButtonText: "OK",
    });
};

/** Render any pending flash alerts declared by the Blade component. */
function renderPendingAlerts() {
    document.querySelectorAll("[data-swal]").forEach((element) => {
        const payload = JSON.parse(element.dataset.swal);

        if (payload.confirm === true) {
            delete payload.confirm;
            window.confirmAction(payload);

            return;
        }

        window.notify(payload.type, payload.title, payload.text);
    });
}

document.addEventListener("DOMContentLoaded", renderPendingAlerts);

Alpine.start();
