const services = {
            direction: {
                eyebrow: "Kierunek → Strategia",
                title: "Kierunek",
                lead: "Zanim marka zacznie mówić, musi wiedzieć, dokąd zmierza. Porządkujemy jej sytuację, określamy pozycję i tworzymy podstawę dla wszystkich kolejnych decyzji.",
                steps: [
                    {
                        title: "Audyt marki",
                        tagline: "Zobacz, gdzie jesteś.",
                        description: "Przyglądamy się marce z szerszej perspektywy, aby zrozumieć, co działa, co ją ogranicza i gdzie kryje się największy potencjał. Zanim zaproponujemy rozwiązania, pomagamy właściwie zdefiniować wyzwania."
                    },
                    {
                        title: "Strategia marki",
                        tagline: "Marka przestaje zgadywać.",
                        description: "Wypracowujemy fundament, na którym opierają się wszystkie kolejne decyzje. Definiujemy pozycjonowanie, wyróżniki, wartości i kierunek rozwoju, dzięki czemu marka staje się spójna i świadoma tego, kim jest."
                    },
                    {
                        title: "Strategia komunikacji",
                        tagline: "Każde słowo ma swój powód.",
                        description: "Pomagamy marce mówić własnym głosem. Tworzymy sposób komunikacji, który porządkuje przekaz i sprawia, że każda publikacja, kampania czy materiał wzmacnia ten sam wizerunek."
                    },
                    {
                        title: "Konsultacje strategiczne",
                        tagline: "Dobry kierunek wymaga dobrych decyzji.",
                        description: "Nie każda marka potrzebuje pełnej strategii. Czasem wystarczy rozmowa, która porządkuje pomysły, weryfikuje założenia i pomaga świadomie zdecydować, co zrobić dalej."
                    }
                ]
            },

            character: {
                eyebrow: "Charakter → Design",
                title: "Charakter",
                lead: "Strategia nabiera znaczenia dopiero wtedy, gdy można ją zobaczyć i poczuć. Budujemy język wizualny, który nadaje marce rozpoznawalną formę i pozwala jej zachować spójność.",
                steps: [
                    {
                        title: "Identyfikacja wizualna",
                        tagline: "Rozpoznawalność rodzi się z konsekwencji.",
                        description: "Tworzymy spójny system identyfikacji, dzięki któremu marka staje się łatwo rozpoznawalna i konsekwentna w każdym punkcie styku. Od nazwy i logo po zasady komunikacji wizualnej — wszystko pracuje na jedną całość."
                    },
                    {
                        title: "Strony internetowe",
                        tagline: "Dobry design prowadzi do celu.",
                        description: "Projektujemy i wdrażamy strony internetowe, sklepy oraz aplikacje, które łączą estetykę z użytecznością. Każdy element powstaje po to, aby wspierać użytkownika i realizować konkretny cel biznesowy."
                    },
                    {
                        title: "Creative Direction",
                        tagline: "Spójność nie jest przypadkiem.",
                        description: "Nadajemy kierunek projektom, kampaniom i działaniom kreatywnym, dbając o to, aby wszystkie elementy opowiadały tę samą historię. Od pomysłu po realizację pilnujemy spójności na każdym etapie."
                    },
                    {
                        title: "Projektowanie odzieży i kolekcji",
                        tagline: "Forma ma znaczenie.",
                        description: "Projektujemy odzież i kolekcje, które stają się naturalnym przedłużeniem marki. Od pierwszego szkicu po produkcję dbamy o każdy etap realizacji, aby końcowy produkt był równie dopracowany jak sam pomysł."
                    }
                ]
            },

            presence: {
                eyebrow: "Obecność → Social Media",
                title: "Obecność",
                lead: "Marka nie istnieje wyłącznie w identyfikacji. Żyje w tym, co mówi, jak reaguje i jak regularnie pojawia się w życiu odbiorców. Budujemy obecność, która ma sens i konsekwencję.",
                steps: [
                    {
                        title: "Social Media",
                        tagline: "Obecność wymaga konsekwencji.",
                        description: "Dbamy o to, aby marka była obecna tam, gdzie są jej odbiorcy. Planujemy komunikację, tworzymy treści i prowadzimy profile w sposób, który buduje relacje, a nie tylko zasięgi."
                    },
                    {
                        title: "Kampanie reklamowe",
                        tagline: "Budżet powinien pracować.",
                        description: "Tworzymy kampanie reklamowe, które wspierają realne cele biznesowe. Od konfiguracji i analityki po codzienną optymalizację dbamy o to, aby każda wydana złotówka przynosiła wartość."
                    },
                    {
                        title: "Produkcja Contentu",
                        tagline: "Dobry obraz przyciąga uwagę.",
                        description: "Tworzymy zdjęcia, filmy i materiały, które pomagają marce wyróżnić się w natłoku treści. Każdy obraz powstaje z myślą o konkretnym celu i wspiera komunikację tam, gdzie liczy się pierwsze wrażenie."
                    },
                    {
                        title: "Influencer Marketing",
                        tagline: "Autentyczność buduje zaufanie.",
                        description: "Łączymy marki z twórcami, którzy naprawdę do nich pasują. Dobieramy partnerów, koordynujemy współpracę i dbamy o to, aby każda kampania była naturalna, wiarygodna i wartościowa dla obu stron."
                    }
                ]
            }
        };


        const routeByService = {
            direction: "/strategia",
            character: "/design",
            presence: "/social-media"
        };

        const serviceByRoute = {
            "/strategia": "direction",
            "/design": "character",
            "/social-media": "presence"
        };

        const serviceLoop = {
            direction: [
                { key: "character", label: "CHARAKTER" },
                { key: "presence", label: "OBECNOŚĆ" }
            ],
            character: [
                { key: "presence", label: "OBECNOŚĆ" },
                { key: "direction", label: "KIERUNEK" }
            ],
            presence: [
                { key: "direction", label: "KIERUNEK" },
                { key: "character", label: "CHARAKTER" }
            ]
        };

(() => {
    const servicePanel = document.querySelector("#service-panel");
    const serviceEyebrow = document.querySelector("#service-eyebrow");
    const serviceTitle = document.querySelector("#service-title");
    const serviceLead = document.querySelector("#service-lead");
    const serviceList = document.querySelector("#service-list");
    const pillars = document.querySelectorAll(".pillar");
    const footerPillars = document.querySelectorAll(".footer-pillar");
    let currentServiceKey = null;

    const pillarForService = key =>
        document.querySelector(`.pillar[data-service="${key}"]`);

    function renderServiceLoop(serviceKey) {
        const items = serviceLoop[serviceKey] || [];
        return `
            <nav class="service-loop" aria-label="Pozostałe obszary">
                ${items.map(item => `
                    <button class="service-loop__button" type="button"
                        data-next-service="${item.key}"
                        aria-label="Przejdź do: ${item.label}">
                        <span class="service-loop__label">${item.label}</span>
                        <span class="service-loop__arrow nav-arrow" aria-hidden="true"></span>
                    </button>
                `).join("")}
            </nav>`;
    }

    function renderService(serviceKey) {
        if (!servicePanel || !serviceEyebrow || !serviceTitle || !serviceLead || !serviceList) return;
        const service = services[serviceKey];
        if (!service) return;

        serviceEyebrow.textContent = service.eyebrow;
        serviceTitle.textContent = service.title;
        serviceLead.textContent = service.lead;
        serviceList.innerHTML = service.steps.map((step, index) => `
            <article class="service-step">
                <div class="service-step__number">${String(index + 1).padStart(2, "0")}</div>
                <div>
                    <h3 class="service-step__title">${step.title}</h3>
                    <p class="service-step__tagline">${step.tagline}</p>
                    <p class="service-step__description">${step.description}</p>
                </div>
            </article>
        `).join("") + renderServiceLoop(serviceKey);

        serviceList.querySelectorAll("[data-next-service]").forEach(button => {
            button.addEventListener("click", () => openService(button.dataset.nextService));
        });
    }

    function closeService() {
        if (!servicePanel) return;
        servicePanel.classList.remove("is-open");
        servicePanel.setAttribute("aria-hidden", "true");
        document.body.classList.remove("bio-is-open");
        pillars.forEach(item => item.classList.remove("is-active"));
        footerPillars.forEach(item => item.classList.remove("is-active"));
    }

    function openService(serviceKey) {
        if (!servicePanel) return;
        const alreadyOpen = servicePanel.classList.contains("is-open");

        pillars.forEach(item => item.classList.toggle("is-active", item.dataset.service === serviceKey));
        footerPillars.forEach(item => item.classList.toggle("is-active", item.dataset.service === serviceKey));

        if (alreadyOpen && currentServiceKey !== serviceKey) {
            servicePanel.classList.add("is-switching");
            window.setTimeout(() => {
                renderService(serviceKey);
                currentServiceKey = serviceKey;
                servicePanel.scrollTop = 0;
                servicePanel.classList.remove("is-switching");
                servicePanel.classList.add("is-entering");
                window.setTimeout(() => servicePanel.classList.remove("is-entering"), 760);
            }, 260);
            return;
        }

        renderService(serviceKey);
        currentServiceKey = serviceKey;
        servicePanel.classList.add("is-open", "is-entering");
        servicePanel.setAttribute("aria-hidden", "false");
        servicePanel.scrollTop = 0;
        document.body.classList.add("bio-is-open");
        window.setTimeout(() => servicePanel.classList.remove("is-entering"), 900);
    }

    pillars.forEach(pillar =>
        pillar.addEventListener("click", () => openService(pillar.dataset.service))
    );
    footerPillars.forEach(pillar =>
        pillar.addEventListener("click", () => openService(pillar.dataset.service))
    );

    document.addEventListener("keydown", event => {
        if (event.key === "Escape" && servicePanel?.classList.contains("is-open")) closeService();
    });

    // Clicking the centered logo closes the service layer before normal navigation.
    document.querySelector(".topbar__studio")?.addEventListener("click", () => closeService());

    // Homepage intro — unchanged timing.
    const siteIntro = document.querySelector(".site-intro");
    const introLogo = document.querySelector(".site-intro__logo");

    function runSiteIntro() {
        if (!siteIntro || !introLogo) {
            document.body.classList.add("hero-pillars-ready", "intro-elements-visible");
            return;
        }

        const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        const navbarLogo = document.querySelector(".topbar__studio img");
        let alreadyShown = false;
        try { alreadyShown = sessionStorage.getItem("inflect-intro-shown") === "1"; } catch (_) {}

        if (reducedMotion || !navbarLogo || alreadyShown) {
            siteIntro.remove();
            document.body.classList.add("hero-pillars-ready", "intro-elements-visible");
            return;
        }

        document.body.classList.add("intro-is-running");
        requestAnimationFrame(() => siteIntro.classList.add("is-visible"));

        window.setTimeout(() => {
            const targetRect = navbarLogo.getBoundingClientRect();
            introLogo.style.left = `${targetRect.left + targetRect.width / 2}px`;
            introLogo.style.top = `${targetRect.top + targetRect.height / 2}px`;
            introLogo.style.width = `${targetRect.width}px`;
            introLogo.style.transform = "translate(-50%, -50%) scale(1)";
            siteIntro.classList.add("is-moving");
        }, 900);

        window.setTimeout(() => {
            siteIntro.classList.add("is-revealing");
            document.body.classList.add("intro-elements-visible");
        }, 1960);

        window.setTimeout(() => document.querySelector('.pillar[data-service="direction"]')?.classList.add("is-intro-revealed"), 2460);
        window.setTimeout(() => document.querySelector('.pillar[data-service="character"]')?.classList.add("is-intro-revealed"), 3260);
        window.setTimeout(() => document.querySelector('.pillar[data-service="presence"]')?.classList.add("is-intro-revealed"), 3860);
        window.setTimeout(() => document.body.classList.add("hero-pillars-ready"), 4380);

        window.setTimeout(() => {
            const studio = document.querySelector(".topbar__studio");
            if (studio) studio.style.opacity = "1";
            siteIntro.classList.add("is-finished");
            try { sessionStorage.setItem("inflect-intro-shown", "1"); } catch (_) {}
        }, 4900);

        window.setTimeout(() => {
            document.body.classList.remove("intro-is-running");
            document.querySelectorAll(".pillar.is-intro-revealed").forEach(p => p.classList.remove("is-intro-revealed"));
            siteIntro.remove();
        }, 5200);
    }

    runSiteIntro();

    // Original interactive hero image response.
    const hero = document.querySelector(".hero");
    if (hero) {
        const stage = document.createElement("div");
        stage.className = "hero-hover-stage";
        const card = document.createElement("div");
        card.className = "hero-hover-image";
        const img = document.createElement("img");
        card.appendChild(img);
        stage.appendChild(card);
        hero.appendChild(stage);

        const folders = { direction: "strategia", character: "design", presence: "sm" };
        let raf = 0, targetX = 0, targetY = 0, currentX = 0, currentY = 0;

        function tick() {
            currentX += (targetX - currentX) * .11;
            currentY += (targetY - currentY) * .11;
            card.style.transform = `translate(calc(-50% + ${currentX}px),calc(-50% + ${currentY}px)) scale(1)`;
            raf = requestAnimationFrame(tick);
        }

        pillars.forEach(pillar => {
            pillar.addEventListener("mouseenter", () => {
                if (!document.body.classList.contains("hero-pillars-ready")) return;
                const rect = pillar.getBoundingClientRect();
                const heroRect = hero.getBoundingClientRect();
                card.style.left = `${rect.left + rect.width / 2 - heroRect.left}px`;
                card.style.top = `${rect.top + rect.height / 2 - heroRect.top}px`;
                const n = Math.floor(Math.random() * 3) + 1;
                img.src = `assets/hero/${folders[pillar.dataset.service]}-hero-${n}.jpg`;
                card.style.opacity = "1";
                currentX = currentY = targetX = targetY = 0;
                cancelAnimationFrame(raf);
                tick();
            });
            pillar.addEventListener("mousemove", event => {
                if (!document.body.classList.contains("hero-pillars-ready")) return;
                const rect = pillar.getBoundingClientRect();
                targetX = ((event.clientX - (rect.left + rect.width / 2)) / rect.width) * 42;
                targetY = ((event.clientY - (rect.top + rect.height / 2)) / rect.height) * 28;
            });
            pillar.addEventListener("mouseleave", () => {
                card.style.opacity = "0";
                cancelAnimationFrame(raf);
            });
        });
    }
})();
