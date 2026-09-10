
(() => {
    const krakowTime = document.querySelector("#krakow-time");
    const contactForm = document.querySelector("#contact-form");
    const contactFormStatus = document.querySelector("#contact-form-status");

    function updateKrakowTime() {
        if (!krakowTime) return;
        krakowTime.textContent = new Intl.DateTimeFormat("pl-PL", {
            timeZone: "Europe/Warsaw",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false
        }).format(new Date());
    }

    updateKrakowTime();
    window.setInterval(updateKrakowTime, 1000);

    contactForm?.addEventListener("submit", event => {
        event.preventDefault();
        const data = new FormData(contactForm);
        const subject = encodeURIComponent(`Nowe zapytanie — ${data.get("name") || "Inflect Studio"}`);
        const body = encodeURIComponent([
            `Imię i nazwisko: ${data.get("name") || ""}`,
            `E-mail: ${data.get("email") || ""}`,
            `Budżet: ${data.get("budget") || "Nie określono"}`,
            "",
            "Opis projektu:",
            data.get("message") || ""
        ].join("\n"));

        if (contactFormStatus) {
            contactFormStatus.textContent = "Otwieram wiadomość w Twoim programie pocztowym…";
        }
        window.location.href = `mailto:hello@inflect.studio?subject=${subject}&body=${body}`;
    });
})();
