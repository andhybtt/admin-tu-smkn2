import './bootstrap';

// Inisialisasi Service Worker PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('ServiceWorker PWA registered successfully: ', registration.scope);
            })
            .catch((error) => {
                console.log('ServiceWorker PWA registration failed: ', error);
            });
    });
}
