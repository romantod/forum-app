import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import type { FlashToast } from '@/types/ui';

export function initializeFlashToast(): void {
    router.on('navigate', (event) => {
        const data = (event.detail.page.props.flash as { toast?: FlashToast })?.toast;

        if (!data) {
            return;
        }

        toast[data.type](data.message);
    });
}
