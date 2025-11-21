function openModal(id, type) {
    document.getElementById('deleteModal').style.display = 'flex';

    if (type === 'branch') {
        document.getElementById('modalTitle').innerText = 'Are you sure, you want delete this branch?';
        document.getElementById('modalMessage').innerText = 'The branch will be permanently deleted from the system.';
        document.getElementById('confirmDelete').href = '?delete_id=' + id;
    } 
    else if (type === 'member') {
        document.getElementById('modalTitle').innerText = 'Are you sure, you want remove this Member?';
        document.getElementById('modalMessage').innerText = 'The member will be permanently removed from the system.';
        document.getElementById('confirmDelete').href = '?action=parmdel&rid=' + id;
        document.getElementById('confirmDelete').innerText = 'Remove';
    }
    else if (type === 'deactivate') {
        document.getElementById('modalTitle').innerText = 'Are you sure you want to deactivate this member?';
        document.getElementById('modalMessage').innerText = 'The member will be marked as inactive and hidden from active lists.';
        document.getElementById('confirmDelete').href = '?disid=' + id;
        document.getElementById('confirmDelete').innerText = 'Deactivate';
    }
    else if (type === 'package') {
        document.getElementById('modalTitle').innerText = 'Are you sure, you want delete this package?';
        document.getElementById('modalMessage').innerText = 'The package will be permanently deleted.';
        document.getElementById('confirmDelete').href = '?delete_id=' + id;
    }
}

function closeModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
