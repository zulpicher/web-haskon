import Alpine from 'alpinejs';
import bukuKas from './modules/buku-kas';
import taskManager from './modules/task';

window.Alpine = Alpine;
Alpine.data('bukuKas', bukuKas);
Alpine.data('taskManager', taskManager);
Alpine.start();
