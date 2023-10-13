const dropdownButton = document.getElementById('dropdownSearchButton');
const dropdownMenu = document.getElementById('dropdownSearch');
const form = document.querySelector('form');
const checkboxes = document.querySelectorAll('input[type="checkbox"]');

dropdownButton.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
});

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
        const selectedCheckboxes = Array.from(checkboxes).filter((cb) => cb.checked);
        const selectedValues = selectedCheckboxes.map((cb) => cb.id);

        const newAction = "/catalogue/" + selectedValues.join("&");
        form.action = newAction;
    });
});