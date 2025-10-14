<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl w-11/12 sm:w-96 p-6">
        <h3 class="text-lg font-semibold mb-2">Confirm Delete</h3>
        <p id="deleteModalMessage" class="text-sm text-gray-600 mb-4">Are you sure you want to delete this task?</p>
        <div class="flex justify-end gap-3">
            <button id="cancelDeleteBtn" class="px-4 py-2 rounded-lg btn-secondary">Cancel</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 rounded-lg btn-gradient text-white">Delete</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.deleteModalInitialized) return;
        window.deleteModalInitialized = true;

        const deleteForms = document.querySelectorAll('.delete-task-form');
        if (!deleteForms || deleteForms.length === 0) return;

        const deleteModal = document.getElementById('deleteModal');
        const deleteModalMessage = document.getElementById('deleteModalMessage');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        let activeDeleteForm = null;

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                activeDeleteForm = this;
                const title = this.dataset.taskTitle || 'this task';
                deleteModalMessage.textContent = `Are you sure you want to delete "${title}"?`;
                deleteModal.classList.remove('hidden');
            });
        });

        cancelDeleteBtn.addEventListener('click', function () {
            deleteModal.classList.add('hidden');
            activeDeleteForm = null;
        });

        confirmDeleteBtn.addEventListener('click', function () {
            if (activeDeleteForm) {
                activeDeleteForm.submit();
            }
        });

        // close modal on outside click
        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
                activeDeleteForm = null;
            }
        });
    });
</script>
