<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt — Inflect Studio</title>
    <link rel="stylesheet" href="assets/css/site.css">
</head>
<body class="page-contact">

<header class="topbar">
    <a class="topbar__studio" href="index.php" aria-label="Inflect Studio — strona główna">
        <img src="assets/inflect-logo-white.svg" alt="Inflect Studio">
    </a>
    <nav class="topbar__nav" aria-label="Główna nawigacja">
        <a class="topbar__bio" href="bio.php"><span class="topbar__bio-label">[ B I O ]</span></a>
        <a class="topbar__projects" href="projekty.php"><span class="topbar__projects-label">[ P R O J E K T Y ]</span></a>
        <a class="topbar__contact" href="kontakt.php"><span class="topbar__contact-label">[ K O N T A K T ]</span></a>
    </nav>
</header>
<div class="page-enter">
    <section
        class="contact-panel"
        id="contact-panel"
        aria-hidden="true"
    >
        <div class="contact-panel__grid">

            <div class="contact-panel__intro">
                <h2 class="contact-panel__headline">
                    Opowiedz nam<br>o swoim projekcie.
                </h2>

                <div class="contact-panel__meta">
                    <div>
                        <div class="contact-panel__meta-label">Kontakt</div>
                        <div class="contact-panel__meta-value">
                            <a class="contact-panel__link" href="mailto:hello@inflect.studio">
                                HELLO@INFLECT.STUDIO
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="contact-panel__meta-label">Lokalizacja</div>
                        <div class="contact-panel__meta-value">
                            Kraków · <span id="krakow-time">--:--</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-panel__form-wrap">
                <form class="contact-form" id="contact-form">

                    <div class="contact-form__field">
                        <label class="contact-form__label" for="contact-name">
                            Imię i nazwisko
                        </label>
                        <input
                            class="contact-form__input"
                            id="contact-name"
                            name="name"
                            type="text"
                            placeholder="Jan Kowalski"
                            required
                        >
                    </div>

                    <div class="contact-form__field">
                        <label class="contact-form__label" for="contact-email">
                            Twój e-mail
                        </label>
                        <input
                            class="contact-form__input"
                            id="contact-email"
                            name="email"
                            type="email"
                            placeholder="hello@twojamarka.pl"
                            required
                        >
                    </div>

                    <div class="contact-form__field">
                        <label class="contact-form__label" for="contact-message">
                            Opowiedz o swoim projekcie
                        </label>
                        <textarea
                            class="contact-form__textarea"
                            id="contact-message"
                            name="message"
                            placeholder="Opisz swój pomysł, wyzwanie lub cel. To wystarczy, żebyśmy mogli dobrze zacząć."
                            required
                        ></textarea>
                    </div>

                    <fieldset class="contact-form__field" style="border:0;">
                        <legend class="contact-form__label">
                            Planowany budżet
                        </legend>

                        <div class="contact-form__budgets">
                            <div>
                                <input class="contact-form__budget-input" id="budget-1" name="budget" type="radio" value="10–20 tys. zł">
                                <label class="contact-form__budget-label" for="budget-1">10–20 tys. zł</label>
                            </div>
                            <div>
                                <input class="contact-form__budget-input" id="budget-2" name="budget" type="radio" value="20–50 tys. zł">
                                <label class="contact-form__budget-label" for="budget-2">20–50 tys. zł</label>
                            </div>
                            <div>
                                <input class="contact-form__budget-input" id="budget-3" name="budget" type="radio" value="50–100 tys. zł">
                                <label class="contact-form__budget-label" for="budget-3">50–100 tys. zł</label>
                            </div>
                            <div>
                                <input class="contact-form__budget-input" id="budget-4" name="budget" type="radio" value="100 tys. zł+">
                                <label class="contact-form__budget-label" for="budget-4">100 tys. zł+</label>
                            </div>
                        </div>
                    </fieldset>

                    <button class="contact-form__submit" type="submit">
                        Wyślij
                    </button>

                    <label class="contact-form__consent">
                        <input type="checkbox" required>
                        <span>
                            Wyrażam zgodę na przetwarzanie moich danych osobowych
                            w celu odpowiedzi na przesłaną wiadomość.
                        </span>
                    </label>

                    <div class="contact-form__status" id="contact-form-status" aria-live="polite"></div>
                </form>
            </div>

        </div>
    </section>
</div>
<script src="assets/js/contact.js" defer></script>
</body>
</html>
