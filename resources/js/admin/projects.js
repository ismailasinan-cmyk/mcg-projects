window.bulkDelete = function () {
    if (confirm('Are you sure you want to delete the selected projects? This action cannot be undone.')) {
        document.getElementById('bulk-form').submit();
    }
};

// Projects page checkbox logic
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.project-checkbox');
    const bulkContainer = document.getElementById('bulk-actions-container');
    const selectedCount = document.getElementById('selected-count');

    if (!selectAll) return;

    function updateBulkUI() {
        const checked = document.querySelectorAll('.project-checkbox:checked');
        if (checked.length > 0) {
            bulkContainer.classList.remove('d-none');
            selectedCount.textContent = checked.length;
        } else {
            bulkContainer.classList.add('d-none');
        }
    }

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => {
            cb.checked = selectAll.checked;
            cb.closest('tr').classList.toggle('table-active', selectAll.checked);
        });
        updateBulkUI();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            cb.closest('tr').classList.toggle('table-active', cb.checked);
            updateBulkUI();

            // Update master checkbox state
            const checkedCount = document.querySelectorAll('.project-checkbox:checked').length;
            selectAll.checked = checkedCount === checkboxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        });
    });
});
