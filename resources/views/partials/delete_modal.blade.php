<div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-slate-900/50" data-confirm-dismiss></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-11/12 sm:w-96 border border-slate-100">
        <div class="p-6 flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-slate-800 uppercase tracking-wide">Delete Confirmation</p>
                <p id="confirm-message" class="text-base text-slate-600 mt-1 break-words">Are you sure?</p>
            </div>
        </div>
        <div class="px-6 pb-6 flex justify-end gap-3">
            <button type="button" class="ghost-btn text-sm" data-confirm-dismiss>Cancel</button>
            <button type="button" class="primary-btn text-sm bg-gradient-to-r from-red-500 to-orange-500 shadow-red-200" id="confirm-yes">Delete</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (window.confirmModalInitialized) return;
        window.confirmModalInitialized = true;

        const modal = document.getElementById('confirm-modal');
        const messageEl = document.getElementById('confirm-message');
        const confirmBtn = document.getElementById('confirm-yes');
        const dismissEls = modal.querySelectorAll('[data-confirm-dismiss]');
        let activeForm = null;

        const openModal = (msg) => {
            messageEl.textContent = msg || 'Are you sure?';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            confirmBtn.focus();
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        const attachHandler = (form, getMessage) => {
            form.addEventListener('submit', (e) => {
                // If already confirmed, let it submit normally.
                if (form.dataset.confirmed === 'true') return;

                e.preventDefault();
                activeForm = form;
                openModal(getMessage(form));
            });
        };

        document.querySelectorAll('form.delete-task-form').forEach(form => {
            attachHandler(form, (f) => {
                const title = f.dataset.taskTitle || 'this task';
                return `Are you sure you want to delete "${title}"?`;
            });
        });

        document.querySelectorAll('form[data-confirm]').forEach(form => {
            attachHandler(form, (f) => f.getAttribute('data-confirm') || 'Are you sure?');
        });

        confirmBtn.addEventListener('click', () => {
            if (!activeForm) return;
            const formToSubmit = activeForm;
            formToSubmit.dataset.confirmed = 'true';
            closeModal();

            if (typeof formToSubmit.requestSubmit === 'function') {
                formToSubmit.requestSubmit();
            } else {
                formToSubmit.submit();
            }

            activeForm = null;
        });

        dismissEls.forEach(el => el.addEventListener('click', () => {
            closeModal();
            activeForm = null;
        }));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
                activeForm = null;
            }
        });
    });
</script>
