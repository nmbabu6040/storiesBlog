import "./bootstrap";
import * as bootstrap from "bootstrap";

window.bootstrap = bootstrap;

import "./frontend/typewriter";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import Chart from "chart.js/auto";
window.Chart = Chart;

document.addEventListener("DOMContentLoaded", function () {
    const theme = localStorage.getItem("theme");

    if (theme === "dark") {
        document.body.classList.add("dark-mode");
    }
});

//admin toggle
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("themeToggle");

    if (!btn) return;

    btn.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");

            btn.innerHTML = "☀️";
        } else {
            localStorage.setItem("theme", "light");

            btn.innerHTML = "🌙";
        }
    });

    if (localStorage.getItem("theme") === "dark") {
        btn.innerHTML = "☀️";
    }
});

//frontend toggle
document.addEventListener("DOMContentLoaded", function () {
    const adminBtn = document.getElementById("themeToggle");
    const frontBtn = document.getElementById("themeToggleFrontend");

    function updateButtons() {
        const dark = document.body.classList.contains("dark-mode");

        if (adminBtn) {
            adminBtn.innerHTML = dark ? "☀️" : "🌙";
        }

        if (frontBtn) {
            frontBtn.innerHTML = dark ? "☀️" : "🌙";
        }
    }

    function toggleTheme() {
        document.body.classList.toggle("dark-mode");

        localStorage.setItem(
            "theme",
            document.body.classList.contains("dark-mode") ? "dark" : "light",
        );

        updateButtons();
    }

    if (adminBtn) {
        adminBtn.addEventListener("click", toggleTheme);
    }

    if (frontBtn) {
        frontBtn.addEventListener("click", toggleTheme);
    }

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
    }

    updateButtons();
});
