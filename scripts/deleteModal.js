let modal = document.getElementById('modal');
let deleteBtn = document.querySelectorAll('.deleteBtn');
let confirmBtn = document.getElementById('confirmBtn');
let cancel = document.getElementById('cancel');

deleteBtn.forEach(dlt => {
    dlt.addEventListener('click', e => {
        modal.showModal();
        modal.classList.remove('hidden');
        let user_id = dlt.value;
        confirmBtn.value = user_id;
    });
});

cancel.addEventListener('click', e => {
    modal.close();
    modal.classList.add('hidden');
    let user_id = deleteBtn.value;
    confirmBtn.value = user_id;
});