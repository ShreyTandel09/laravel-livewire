<div
    x-data="{
        show: false,
        type: 'success',
        message: '',
        timeout: null,
        showToast(event) {

        let detail = event.detail;

        if (Array.isArray(detail)) {
            detail = detail[0];
        }
            this.type = detail.type;
            this.message = detail.message;
            this.show = true;

            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.show = false;
            }, 4000);
        }
    }"
    x-init="window.addEventListener('showToast', e => showToast(e))"
    x-show="show"
    x-transition
    class="fixed top-6 right-6 z-50 max-w-sm w-full p-4 rounded-md shadow-lg text-white"
    :class="{
        'bg-green-500': type === 'success',
        'bg-red-500': type === 'error',
        'bg-yellow-500': type === 'warning',
        'bg-blue-500': type === 'info'
    }"
    style="display: none;">
    <div class="flex items-center justify-between">
        <span x-text="message"></span>
        <button @click="show = false" class="ml-4 font-bold">&times;</button>
    </div>
</div>