document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("type");
    const devForm = document.getElementById("dev-form");
    const entrepriseForm = document.getElementById("entreprise-form");

    function toggleForms() {
        const value = select.value;
        if (value === "dev") {
            devForm.classList.remove("hidden");
            entrepriseForm.classList.add("hidden");
        } else if (value === "entreprise") {
            entrepriseForm.classList.remove("hidden");
            devForm.classList.add("hidden");
        } else {
            devForm.classList.add("hidden");
            entrepriseForm.classList.add("hidden");
        }
    }

    select.addEventListener("change", toggleForms);
    toggleForms(); // pour gérer le cas où old('type') est déjà présent
});
