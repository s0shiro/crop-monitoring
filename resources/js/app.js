import "./bootstrap";
import Alpine from "alpinejs";
import * as Turbo from "@hotwired/turbo";

window.Alpine = Alpine;
Alpine.start();

// Add Turbo event handlers for map initialization
document.addEventListener("turbo:load", () => {
    if (document.getElementById('map')) {
        // Use setTimeout to ensure DOM is ready
        setTimeout(() => {
            if (typeof initMap === 'function') {
                initMap();
            }
        }, 100);
    }
});

Turbo.start();
