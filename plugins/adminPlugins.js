document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('students-table');

    table.addEventListener('click', (event) => {
        const target = event.target;
        console.log(target);
    });
});