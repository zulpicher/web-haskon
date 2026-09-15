import Alpine from 'alpinejs';
import bukuKas from './modules/buku-kas';

window.Alpine = Alpine;
Alpine.data('bukuKas', bukuKas);
Alpine.start();
