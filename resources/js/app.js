import "./bootstrap";
import * as bootstrap from "bootstrap";

window.bootstrap = bootstrap;

import "./frontend/typewriter";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import Chart from "chart.js/auto";
window.Chart = Chart;

//admin dark theme toggle
document.addEventListener("DOMContentLoaded", function () {
    const adminBtn = document.getElementById("themeToggle");

    if (!adminBtn) return;

    // Load admin theme only
    if (localStorage.getItem("admin-theme") === "dark") {
        document.body.classList.add("dark-mode");
    }

    updateAdminButton();

    adminBtn.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("admin-theme", "dark");
        } else {
            localStorage.setItem("admin-theme", "light");
        }

        updateAdminButton();
    });

    function updateAdminButton() {
        adminBtn.innerHTML = document.body.classList.contains("dark-mode")
            ? "☀️"
            : "🌙";
    }
});

//user dark mode theme toggle
document.addEventListener("DOMContentLoaded", function () {
    const frontBtn = document.getElementById("themeToggleFrontend");

    if (!frontBtn) return;

    // Load frontend theme only
    if (localStorage.getItem("frontend-theme") === "dark") {
        document.body.classList.add("dark-mode");
    }

    updateFrontendButton();

    frontBtn.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("frontend-theme", "dark");
        } else {
            localStorage.setItem("frontend-theme", "light");
        }

        updateFrontendButton();
    });

    function updateFrontendButton() {
        frontBtn.innerHTML = document.body.classList.contains("dark-mode")
            ? "☀️"
            : "🌙";
    }
});
