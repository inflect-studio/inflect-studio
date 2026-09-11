<?php
$projectsManifest = __DIR__ . '/assets/projects/projects.json';
$projects = [];
if (is_file($projectsManifest)) {
    $decoded = json_decode((string) file_get_contents($projectsManifest), true);
    if (is_array($decoded)) $projects = $decoded;
}
if (!$projects) {
    for ($i = 1; $i <= 25; $i++) $projects[] = ['file' => 'project' . $i . '.jpeg'];
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inflect Studio</title>

    <style>
        :root {
            --background: #111111;
            --foreground: #ffffff;
            --muted: rgba(255, 255, 255, 0.58);
            --transition: 500ms cubic-bezier(0.22, 1, 0.36, 1);
            --header-height: 72px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        html {
            background: var(--background);
        }

        body {
            overflow-x: hidden;
            background: var(--background);
            color: var(--foreground);
            font-family:
                Inter,
                "Helvetica Neue",
                Helvetica,
                Arial,
                sans-serif;
        }

        body.bio-is-open {
            overflow: hidden;
        }

        button {
            color: inherit;
            font: inherit;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            width: 100%;
            height: var(--header-height);
            padding: 0 22px;
            pointer-events: none;
        }

        .topbar__bio {
            justify-self: start;
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            pointer-events: auto;
        }

        .topbar__bio-label {
            display: inline-block;
            min-width: 58px;
            text-align: left;
        }

        .topbar__contact {
            justify-self: end;
            border: 0;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            pointer-events: auto;
        }

        .topbar__contact-label {
            display: inline-block;
            min-width: 124px;
            text-align: right;
        }

.topbar__studio {
    justify-self: center;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: auto;
}

.topbar__studio img {
    display: block;
    width: auto;
    height: 18px;
}


        .bio-panel {
            position: fixed;
            inset: 0;
            z-index: 900;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: 100svh;
            padding:
                calc(var(--header-height) + 52px)
                22px
                46px;
            overflow-y: auto;
            background: var(--background);
            transform: translateY(-100%);
            visibility: hidden;
            transition:
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s linear 700ms;
            will-change: transform;
        }

        .bio-panel.is-open {
            transform: translateY(0);
            visibility: visible;
            transition:
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s;
        }

        .bio-panel__grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.65fr)
                minmax(260px, 0.65fr);
            gap: clamp(64px, 10vw, 180px);
            width: 100%;
            margin-top: auto;
            margin-bottom: auto;
        }

        .bio-panel__label {
            margin-bottom: 16px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .bio-panel__text {
            max-width: 1050px;
            font-size: clamp(30px, 3.2vw, 58px);
            font-weight: 400;
            line-height: 0.99;
            letter-spacing: -0.052em;
        }

        .bio-panel__text p + p {
            margin-top: 0.9em;
        }

        .bio-panel__side {
            align-self: end;
            display: flex;
            flex-direction: column;
            gap: 44px;
            padding-bottom: 4px;
        }

        .bio-panel__side-block {
            max-width: 350px;
        }

        .bio-panel__side-title {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .bio-panel__side-text {
            font-size: clamp(19px, 1.45vw, 26px);
            font-weight: 400;
            line-height: 1.08;
            letter-spacing: -0.035em;
        }


        .contact-panel {
            position: fixed;
            inset: 0;
            z-index: 890;
            width: 100%;
            min-height: 100svh;
            padding:
                calc(var(--header-height) + 52px)
                22px
                42px;
            overflow-y: auto;
            background: var(--background);
            transform: translateY(-100%);
            visibility: hidden;
            transition:
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s linear 700ms;
            will-change: transform;
        }

        .contact-panel.is-open {
            transform: translateY(0);
            visibility: visible;
            transition:
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s;
        }

        .contact-panel__grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                minmax(420px, 0.92fr);
            gap: clamp(64px, 9vw, 150px);
            width: 100%;
            min-height: calc(100svh - var(--header-height) - 94px);
        }

        .contact-panel__intro {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
        }

        .contact-panel__headline {
            max-width: 760px;
            font-size: clamp(48px, 5.4vw, 96px);
            font-weight: 400;
            line-height: 0.96;
            letter-spacing: -0.06em;
        }

        .contact-panel__meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 34px;
            max-width: 640px;
            padding-top: 90px;
        }

        .contact-panel__meta-label,
        .contact-form__label {
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 500;
            line-height: 1.2;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .contact-panel__meta-value {
            font-size: 18px;
            line-height: 1.25;
            letter-spacing: -0.025em;
        }

        .contact-panel__link {
            color: inherit;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.45);
        }

        .contact-panel__form-wrap {
            display: flex;
            align-items: center;
        }

        .contact-form {
            width: 100%;
        }

        .contact-form__field {
            margin-bottom: 28px;
        }

        .contact-form__input,
        .contact-form__textarea {
            width: 100%;
            border: 0;
            border-bottom: 1px solid rgba(255,255,255,0.26);
            border-radius: 0;
            outline: 0;
            background: transparent;
            color: var(--foreground);
            font: inherit;
            font-size: 16px;
            line-height: 1.4;
            padding: 4px 0 16px;
        }

        .contact-form__textarea {
            min-height: 118px;
            resize: vertical;
        }

        .contact-form__input::placeholder,
        .contact-form__textarea::placeholder {
            color: rgba(255,255,255,0.22);
        }

        .contact-form__input:focus,
        .contact-form__textarea:focus {
            border-bottom-color: var(--foreground);
        }

        .contact-form__budgets {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
            margin-top: 16px;
        }

        .contact-form__budget-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .contact-form__budget-label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 999px;
            cursor: pointer;
            font-size: 12px;
            line-height: 1.1;
            text-align: center;
            transition:
                background 180ms ease,
                color 180ms ease,
                border-color 180ms ease;
        }

        .contact-form__budget-input:checked + .contact-form__budget-label {
            background: var(--foreground);
            color: var(--background);
            border-color: var(--foreground);
        }

        .contact-form__submit {
            width: 100%;
            margin-top: 34px;
            min-height: 54px;
            border: 1px solid var(--foreground);
            background: var(--foreground);
            color: var(--background);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .contact-form__consent {
            display: grid;
            grid-template-columns: 16px 1fr;
            gap: 10px;
            align-items: start;
            margin-top: 18px;
            color: var(--muted);
            font-size: 9px;
            line-height: 1.35;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .contact-form__consent input {
            width: 14px;
            height: 14px;
            margin: 0;
            accent-color: var(--foreground);
        }

        .contact-form__status {
            min-height: 20px;
            margin-top: 14px;
            color: var(--muted);
            font-size: 12px;
        }


        .service-panel {
            position: fixed;
            inset: 0;
            z-index: 880;
            width: 100%;
            min-height: 100svh;
            overflow-y: auto;
            background: var(--background);
            opacity: 0;
            visibility: hidden;
            transform: translateY(28px);
            transition:
                opacity 420ms ease,
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s linear 700ms;
        }

        .service-panel.is-open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition:
                opacity 420ms ease,
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s;
        }

        .service-panel__inner {
            display: grid;
            grid-template-columns:
                minmax(300px, 0.9fr)
                minmax(0, 1.1fr);
            gap: clamp(70px, 10vw, 180px);
            width: 100%;
            min-height: 100svh;
            padding:
                calc(var(--header-height) + 70px)
                clamp(22px, 4vw, 72px)
                70px;
        }

        .service-panel__intro {
            position: static;
            align-self: start;
        }

        .service-panel__eyebrow {
            margin-bottom: 18px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .service-panel__title {
            max-width: 720px;
            font-size: clamp(54px, 7vw, 120px);
            font-weight: 600;
            line-height: 0.9;
            letter-spacing: -0.065em;
        }

        .service-panel__lead {
            max-width: 580px;
            margin-top: 34px;
            color: rgba(255, 255, 255, 0.72);
            font-size: clamp(19px, 1.55vw, 27px);
            font-weight: 400;
            line-height: 1.13;
            letter-spacing: -0.035em;
        }

        .service-panel__close {
            position: fixed;
            top: 28px;
            right: 22px;
            z-index: 910;
            border: 0;
            background: transparent;
            color: var(--foreground);
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .service-panel__list {
            align-self: center;
            width: 100%;
        }

        .service-step {
            display: grid;
            grid-template-columns: 56px minmax(0, 1fr);
            gap: 24px;
            padding: 28px 0 34px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            transform: translateY(18px);
            transition:
                opacity 480ms ease,
                transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        .service-step:last-child {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .service-panel.is-open .service-step {
            opacity: 1;
            transform: translateY(0);
        }

        .service-panel.is-open .service-step:nth-child(1) { transition-delay: 160ms; }
        .service-panel.is-open .service-step:nth-child(2) { transition-delay: 230ms; }
        .service-panel.is-open .service-step:nth-child(3) { transition-delay: 300ms; }
        .service-panel.is-open .service-step:nth-child(4) { transition-delay: 370ms; }
        .service-panel.is-open .service-step:nth-child(5) { transition-delay: 440ms; }

        .service-step__number {
            padding-top: 4px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
        }

        .service-step__title {
            margin-bottom: 10px;
            font-size: clamp(25px, 2.4vw, 43px);
            font-weight: 500;
            line-height: 1;
            letter-spacing: -0.045em;
        }

        .service-step__description {
            max-width: 760px;
            color: rgba(255, 255, 255, 0.62);
            font-size: clamp(15px, 1.18vw, 19px);
            line-height: 1.38;
            letter-spacing: -0.02em;
        }

        .hero {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            grid-template-rows:
    minmax(var(--header-height), 1fr)
    auto
    1fr
    auto;
            width: 100%;
            min-width: 0;
            min-height: 100svh;
            overflow: hidden;
            padding:
                var(--header-height)
                0
                32px;
        }

        .hero__content {
            grid-column: 1;
            grid-row: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-width: 0;
            padding: 32px clamp(24px, 4vw, 72px);
            text-align: center;
        }

        .pillars {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: center;
            width: 100%;
            min-width: 0;
            max-width: 1600px;
            margin-inline: auto;
        }

        .pillar {
            position: relative;
            width: 100%;
            min-width: 0;
            height: 1.12em;
            border: 0;
            background: transparent;
            cursor: pointer;
            user-select: none;
            overflow: hidden;
            font-size: clamp(36px, 5.4vw, 92px);
            font-weight: 600;
            line-height: 1.12;
            letter-spacing: -0.055em;
            text-align: center;
        }

        .pillar__sizer {
            display: block;
            visibility: hidden;
            white-space: nowrap;
        }

        .pillar__track {
            position: absolute;
            top: 0;
            left: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: max-content;
            transform: translate(-50%, 0);
            transition: transform var(--transition);
            will-change: transform;
        }

        .pillar__text {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 1.12em;
            white-space: nowrap;
        }

        .pillar:hover .pillar__track,
        .pillar:focus-visible .pillar__track,
        .pillar.is-active .pillar__track {
            transform: translate(-50%, -50%);
        }

        .pillar:focus-visible,
        .topbar__bio:focus-visible,
        .topbar__contact:focus-visible {
            outline: 1px solid var(--foreground);
            outline-offset: 8px;
        }

        .separator {
            display: none;
        }

        .claim {
            grid-column: 1;
            grid-row: 3;
            align-self: center;
            justify-self: center;
            padding: 20px 24px;
            font-size: clamp(15px, 1.35vw, 20px);
            font-weight: 400;
            line-height: 1.4;
            letter-spacing: -0.02em;
            text-align: center;
        }

        .logos {
            grid-column: 1;
            grid-row: 4;
            width: 100%;
            min-width: 0;
            overflow: hidden;
        }

        .logos__viewport {
            position: relative;
            width: 100%;
            overflow: hidden;
            -webkit-mask-image:
                linear-gradient(
                    to right,
                    transparent 0%,
                    black 8%,
                    black 92%,
                    transparent 100%
                );
            mask-image:
                linear-gradient(
                    to right,
                    transparent 0%,
                    black 8%,
                    black 92%,
                    transparent 100%
                );
        }

        .logos__track {
            display: flex;
            align-items: center;
            width: max-content;
            animation: marquee 50s linear infinite;
            will-change: transform;
        }

        .logos__group {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            gap: clamp(90px, 7vw, 180px);
            padding-right: clamp(90px, 7vw, 180px);
        }

.logo {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;

    width: 150px;
    height: 44px;

    opacity: 0.42;

    transition:
        opacity 250ms ease,
        transform 250ms ease;
}

.logo img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: contain;

    filter: brightness(0) invert(1);

    user-select: none;
    pointer-events: none;
}

.logo:hover {
    opacity: 1;
}

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media (hover: hover) {
            .logos__viewport:hover .logos__track {
                animation-play-state: paused;
            }
        }

        @media (max-width: 1100px) {
            .service-panel__inner {
                grid-template-columns: minmax(250px, 0.72fr) minmax(0, 1.28fr);
                gap: 60px;
            }
        }

        @media (max-width: 1000px) {
            .bio-panel__grid {
                grid-template-columns: 1fr;
                gap: 70px;
            }

            .bio-panel__side {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 30px;
            }
        }

        @media (max-width: 900px) {
            :root {
                --header-height: 66px;
            }

            .topbar {
                padding-inline: 18px;
            }

            .bio-panel {
                padding:
                    calc(var(--header-height) + 40px)
                    18px
                    36px;
            }

            .hero {
                grid-template-rows:
                    minmax(var(--header-height), 1fr)
                    auto
                    minmax(100px, 0.75fr)
                    auto;
            }

            .pillars {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .service-panel__inner {
                display: block;
                min-height: 100svh;
                padding:
                    calc(var(--header-height) + 72px)
                    16px
                    48px;
            }

            .service-panel__intro {
                position: static;
                margin-bottom: 66px;
            }

            .service-panel__title {
                font-size: clamp(54px, 17vw, 88px);
            }

            .service-panel__lead {
                margin-top: 26px;
                font-size: 19px;
            }

            .service-panel__close {
                top: 25px;
                right: 14px;
                font-size: 10px;
            }

            .service-step {
                grid-template-columns: 36px minmax(0, 1fr);
                gap: 14px;
                padding: 24px 0 28px;
            }

            .service-step__title {
                font-size: clamp(26px, 8vw, 38px);
            }

            .service-step__description {
                font-size: 15px;
            }
        }

        @media (max-width: 720px) {
            :root {
                --header-height: 62px;
            }

            .topbar {
                padding-inline: 14px;
            }

            .topbar__bio,
            .topbar__contact {
                font-size: 10px;
            }

            .topbar__bio-label {
                min-width: 48px;
            }

            .topbar__contact-label {
                min-width: 96px;
            }

.topbar__studio img {
    height: 15px;
}

            .hero {
                grid-template-rows:
                    minmax(var(--header-height), 1fr)
                    auto
                    minmax(112px, 0.85fr)
                    auto;
                padding-bottom: 22px;
            }

            .hero__content {
                padding-inline: 16px;
            }

            .pillars {
                grid-template-columns: 1fr;
                row-gap: 10px;
                width: 100%;
                max-width: none;
            }

            .pillar {
                width: 100%;
                font-size: clamp(34px, 11vw, 58px);
            }

    

            .logos__track {
                animation-duration: 44s;
            }

            .logos__group {
                gap: 72px;
                padding-right: 72px;
            }

            .bio-panel {
                padding:
                    calc(var(--header-height) + 34px)
                    16px
                    34px;
            }

            .contact-panel {
                padding:
                    calc(var(--header-height) + 34px)
                    16px
                    34px;
            }

            .contact-panel__grid {
                grid-template-columns: 1fr;
                gap: 64px;
                min-height: auto;
            }

            .contact-panel__headline {
                font-size: clamp(42px, 12vw, 68px);
            }

            .contact-panel__meta {
                grid-template-columns: 1fr;
                gap: 28px;
                padding-top: 64px;
            }

            .contact-panel__form-wrap {
                align-items: flex-start;
            }

            .contact-form__budgets {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bio-panel__grid {
                gap: 54px;
            }

            .bio-panel__text {
                font-size: clamp(28px, 8vw, 42px);
                line-height: 1.02;
            }

            .bio-panel__side {
                grid-template-columns: 1fr;
                gap: 34px;
            }
        }

        @media (max-width: 480px) {
            .pillars {
                row-gap: 8px;
            }

            .pillar {
                font-size: clamp(32px, 10.5vw, 46px);
            }

            .bio-panel__text {
                letter-spacing: -0.042em;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .pillar__track,
            .bio-panel,
            .contact-panel,
            .service-panel,
            .service-step {
                transition-duration: 1ms;
            }

            .logos__track {
                animation-play-state: paused;
            }
        }
    
        /* =========================================================
           INFLECT — SPÓJNY SYSTEM TYPOGRAFII I ODSTĘPÓW
        ========================================================= */

        :root {
            --page-gutter: clamp(18px, 2.4vw, 36px);
            --panel-gutter: clamp(18px, 4vw, 72px);

            --space-1: 8px;
            --space-2: 12px;
            --space-3: 16px;
            --space-4: 24px;
            --space-5: 32px;
            --space-6: 48px;
            --space-7: 64px;
            --space-8: 96px;

            --type-micro: 10px;
            --type-label: 11px;
            --type-body: clamp(15px, 1vw, 17px);
            --type-body-large: clamp(18px, 1.4vw, 24px);
            --type-heading-small: clamp(25px, 2.2vw, 40px);
            --type-heading-medium: clamp(42px, 5vw, 82px);
            --type-display: clamp(48px, 5.4vw, 92px);
            --type-display-large: clamp(56px, 7vw, 112px);

            --tracking-label: 0.16em;
            --tracking-tight: -0.045em;
            --tracking-display: -0.06em;

            --leading-tight: 0.96;
            --leading-body: 1.42;
        }

        body {
            -webkit-font-smoothing: antialiased;
            text-rendering: geometricPrecision;
        }

        .topbar {
            padding-inline: var(--page-gutter);
        }

        .topbar__bio,
        .topbar__contact,
        .service-panel__close {
            font-size: var(--type-label);
            font-weight: 500;
            line-height: 1;
            letter-spacing: var(--tracking-label);
        }

        .topbar__studio img {
            height: 18px;
        }

        .bio-panel,
        .contact-panel {
            padding:
                calc(var(--header-height) + var(--space-6))
                var(--page-gutter)
                var(--space-6);
        }

        .bio-panel__grid {
            gap: clamp(64px, 9vw, 160px);
        }

        .bio-panel__label,
        .bio-panel__side-title,
        .service-panel__eyebrow,
        .contact-panel__meta-label,
        .contact-form__label {
            font-size: var(--type-label);
            font-weight: 500;
            line-height: 1.2;
            letter-spacing: var(--tracking-label);
        }

        .bio-panel__label {
            margin-bottom: var(--space-3);
        }

        .bio-panel__text {
            max-width: 1080px;
            font-size: var(--type-heading-medium);
            line-height: var(--leading-tight);
            letter-spacing: var(--tracking-display);
        }

        .bio-panel__text p + p {
            margin-top: 0.82em;
        }

        .bio-panel__side {
            gap: var(--space-6);
        }

        .bio-panel__side-title {
            margin-bottom: var(--space-2);
        }

        .bio-panel__side-text {
            font-size: var(--type-body-large);
            line-height: 1.18;
            letter-spacing: -0.03em;
        }

        .contact-panel__grid {
            gap: clamp(64px, 8vw, 140px);
        }

        .contact-panel__headline {
            max-width: 820px;
            font-size: var(--type-display);
            line-height: var(--leading-tight);
            letter-spacing: var(--tracking-display);
        }

        .contact-panel__meta {
            gap: var(--space-5);
            padding-top: var(--space-8);
        }

        .contact-panel__meta-label,
        .contact-form__label {
            margin-bottom: var(--space-2);
        }

        .contact-panel__meta-value {
            font-size: var(--type-body-large);
            line-height: 1.28;
            letter-spacing: -0.025em;
        }

        .contact-form__field {
            margin-bottom: var(--space-5);
        }

        .contact-form__input,
        .contact-form__textarea {
            font-size: var(--type-body);
            line-height: var(--leading-body);
            padding: 4px 0 var(--space-3);
        }

        .contact-form__textarea {
            min-height: 124px;
        }

        .contact-form__budgets {
            gap: var(--space-1);
            margin-top: var(--space-3);
        }

        .contact-form__budget-label {
            min-height: 44px;
            font-size: var(--type-label);
        }

        .contact-form__submit {
            min-height: 56px;
            margin-top: var(--space-5);
            font-size: var(--type-label);
            letter-spacing: 0.08em;
        }

        .contact-form__consent {
            gap: var(--space-2);
            margin-top: var(--space-3);
            font-size: var(--type-micro);
            line-height: 1.4;
            letter-spacing: 0.06em;
        }

        .contact-form__status {
            margin-top: var(--space-2);
            font-size: var(--type-label);
        }

        .service-panel__inner {
            gap: clamp(70px, 9vw, 160px);
            padding:
                calc(var(--header-height) + var(--space-7))
                var(--panel-gutter)
                var(--space-7);
        }

        .service-panel__intro {
            top: calc(var(--header-height) + var(--space-7));
        }

        .service-panel__eyebrow {
            margin-bottom: var(--space-3);
        }

        .service-panel__title {
            font-size: var(--type-display-large);
            line-height: 0.9;
            letter-spacing: -0.065em;
        }

        .service-panel__lead {
            margin-top: var(--space-5);
            font-size: var(--type-body-large);
            line-height: 1.22;
            letter-spacing: -0.03em;
        }

        .service-panel__close {
            top: 30px;
            right: var(--page-gutter);
        }

        .service-step {
            grid-template-columns: 52px minmax(0, 1fr);
            gap: var(--space-4);
            padding: var(--space-5) 0;
        }

        .service-step__number {
            padding-top: 5px;
            font-size: var(--type-label);
        }

        .service-step__title {
            margin-bottom: var(--space-2);
            font-size: var(--type-heading-small);
            letter-spacing: var(--tracking-tight);
        }

        .service-step__description {
            font-size: var(--type-body);
            line-height: var(--leading-body);
            letter-spacing: -0.015em;
        }

        .hero {
            padding-bottom: var(--space-5);
        }

        .hero__content {
            padding: var(--space-5) var(--panel-gutter);
        }

        .pillar {
            font-size: clamp(38px, 5.2vw, 88px);
            line-height: 1.08;
        }

        .pillar__text {
            height: 1.08em;
        }

        .logos__group {
            gap: clamp(96px, 8vw, 176px);
            padding-right: clamp(96px, 8vw, 176px);
        }

        @media (max-width: 720px) {
            :root {
                --page-gutter: 16px;
                --panel-gutter: 16px;
                --space-8: 72px;
            }

            .topbar__studio img {
                height: 15px;
            }

            .bio-panel,
            .contact-panel {
                padding:
                    calc(var(--header-height) + var(--space-5))
                    var(--page-gutter)
                    var(--space-5);
            }

            .bio-panel__grid,
            .contact-panel__grid {
                gap: var(--space-7);
            }

            .bio-panel__text {
                font-size: clamp(32px, 9vw, 46px);
                line-height: 1;
            }

            .bio-panel__side {
                gap: var(--space-5);
            }

            .bio-panel__side-text,
            .contact-panel__meta-value,
            .service-panel__lead {
                font-size: 18px;
                line-height: 1.25;
            }

            .contact-panel__headline {
                font-size: clamp(42px, 12vw, 64px);
            }

            .contact-panel__meta {
                gap: var(--space-5);
                padding-top: var(--space-7);
            }

            .service-panel__inner {
                padding:
                    calc(var(--header-height) + var(--space-7))
                    var(--panel-gutter)
                    var(--space-6);
            }

            .service-panel__intro {
                margin-bottom: var(--space-7);
            }

            .service-panel__title {
                font-size: clamp(52px, 16vw, 82px);
            }

            .service-panel__lead {
                margin-top: var(--space-4);
            }

            .service-step {
                grid-template-columns: 34px minmax(0, 1fr);
                gap: var(--space-3);
                padding: var(--space-4) 0;
            }

            .service-step__title {
                font-size: clamp(26px, 7.5vw, 36px);
            }

            .service-step__description {
                font-size: 15px;
                line-height: 1.45;
            }

            .hero {
                padding-bottom: var(--space-4);
            }

            .hero__content {
                padding: var(--space-4) var(--page-gutter);
            }

            .pillars {
                row-gap: var(--space-1);
            }

            .pillar {
                font-size: clamp(34px, 11vw, 54px);
            }

            .logos__group {
                gap: 80px;
                padding-right: 80px;
            }

            .logo {
                width: 138px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .pillar {
                font-size: clamp(32px, 10.5vw, 46px);
            }

            .contact-form__budget-label {
                font-size: 10px;
            }
        }

    
        /* =========================================================
           PROJECT STACK — LOSOWE PRZEJŚCIA Z REALIZACJAMI
        ========================================================= */


        /* PROJECTS + NAVBAR */
        .topbar { display:flex; justify-content:space-between; align-items:center; }
        .topbar__studio { display:flex; align-items:center; justify-content:flex-start; pointer-events:auto; }
        .topbar__nav { display:flex; align-items:center; justify-content:flex-end; gap:clamp(16px,2vw,34px); pointer-events:auto; }
        .topbar__bio,.topbar__areas,.topbar__projects,.topbar__contact { border:0; background:transparent; cursor:pointer; font-size:var(--type-label); font-weight:500; line-height:1; letter-spacing:var(--tracking-label); text-transform:uppercase; }
        .topbar__bio-label,.topbar__areas-label,.topbar__projects-label,.topbar__contact-label { display:inline-block; min-width:0; text-align:right; }
        .projects-panel { position:fixed; inset:0; z-index:895; width:100%; height:100svh; overflow-y:auto; overflow-x:hidden; background:var(--background); transform:translateY(-100%); visibility:hidden; transition:transform 700ms cubic-bezier(.22,1,.36,1),visibility 0s linear 700ms; will-change:transform; }
        .projects-panel.is-open { transform:translateY(0); visibility:visible; transition:transform 700ms cubic-bezier(.22,1,.36,1),visibility 0s; }
        .projects-panel__canvas { position:relative; min-height:7200px; padding-top:calc(var(--header-height) + 72px); padding-bottom:140px; }
        .projects-panel__canvas img { position:absolute; display:block; width:var(--w); left:var(--x); top:var(--y); height:auto; object-fit:contain; box-shadow:none; border-radius:0; }
        .projects-panel__canvas img:nth-child(1){--x:5%;--y:150px;--w:38%}.projects-panel__canvas img:nth-child(2){--x:58%;--y:320px;--w:31%}.projects-panel__canvas img:nth-child(3){--x:22%;--y:690px;--w:54%}.projects-panel__canvas img:nth-child(4){--x:4%;--y:1080px;--w:27%}.projects-panel__canvas img:nth-child(5){--x:48%;--y:1210px;--w:44%}.projects-panel__canvas img:nth-child(6){--x:14%;--y:1570px;--w:36%}.projects-panel__canvas img:nth-child(7){--x:60%;--y:1740px;--w:26%}.projects-panel__canvas img:nth-child(8){--x:30%;--y:2070px;--w:58%}.projects-panel__canvas img:nth-child(9){--x:4%;--y:2490px;--w:32%}.projects-panel__canvas img:nth-child(10){--x:52%;--y:2610px;--w:40%}.projects-panel__canvas img:nth-child(11){--x:18%;--y:3010px;--w:47%}.projects-panel__canvas img:nth-child(12){--x:69%;--y:3240px;--w:23%}.projects-panel__canvas img:nth-child(13){--x:4%;--y:3500px;--w:37%}.projects-panel__canvas img:nth-child(14){--x:44%;--y:3660px;--w:52%}.projects-panel__canvas img:nth-child(15){--x:12%;--y:4110px;--w:28%}.projects-panel__canvas img:nth-child(16){--x:55%;--y:4230px;--w:35%}.projects-panel__canvas img:nth-child(17){--x:24%;--y:4540px;--w:59%}.projects-panel__canvas img:nth-child(18){--x:3%;--y:4960px;--w:31%}.projects-panel__canvas img:nth-child(19){--x:61%;--y:5080px;--w:31%}.projects-panel__canvas img:nth-child(20){--x:29%;--y:5380px;--w:43%}.projects-panel__canvas img:nth-child(21){--x:7%;--y:5680px;--w:27%}.projects-panel__canvas img:nth-child(22){--x:50%;--y:5770px;--w:46%}.projects-panel__canvas img:nth-child(23){--x:17%;--y:6120px;--w:39%}.projects-panel__canvas img:nth-child(24){--x:66%;--y:6350px;--w:25%}.projects-panel__canvas img:nth-child(25){--x:25%;--y:6640px;--w:55%}
        @media(max-width:720px){.topbar__nav{gap:12px}.topbar__bio,.topbar__projects,.topbar__contact{font-size:9px;letter-spacing:.11em}.projects-panel__canvas{min-height:7600px;padding-top:calc(var(--header-height) + 48px)}.projects-panel__canvas img:nth-child(odd){--x:4%;--w:72%}.projects-panel__canvas img:nth-child(even){--x:28%;--w:68%}.projects-panel__canvas img:nth-child(1){--y:110px}.projects-panel__canvas img:nth-child(2){--y:400px}.projects-panel__canvas img:nth-child(3){--y:700px}.projects-panel__canvas img:nth-child(4){--y:1000px}.projects-panel__canvas img:nth-child(5){--y:1300px}.projects-panel__canvas img:nth-child(6){--y:1600px}.projects-panel__canvas img:nth-child(7){--y:1900px}.projects-panel__canvas img:nth-child(8){--y:2200px}.projects-panel__canvas img:nth-child(9){--y:2500px}.projects-panel__canvas img:nth-child(10){--y:2800px}.projects-panel__canvas img:nth-child(11){--y:3100px}.projects-panel__canvas img:nth-child(12){--y:3400px}.projects-panel__canvas img:nth-child(13){--y:3700px}.projects-panel__canvas img:nth-child(14){--y:4000px}.projects-panel__canvas img:nth-child(15){--y:4300px}.projects-panel__canvas img:nth-child(16){--y:4600px}.projects-panel__canvas img:nth-child(17){--y:4900px}.projects-panel__canvas img:nth-child(18){--y:5200px}.projects-panel__canvas img:nth-child(19){--y:5500px}.projects-panel__canvas img:nth-child(20){--y:5800px}.projects-panel__canvas img:nth-child(21){--y:6100px}.projects-panel__canvas img:nth-child(22){--y:6400px}.projects-panel__canvas img:nth-child(23){--y:6700px}.projects-panel__canvas img:nth-child(24){--y:7000px}.projects-panel__canvas img:nth-child(25){--y:7300px}}


        /* SERVICE PANEL — CTA + INVERT HOVER */
        .service-panel__intro {
            display: flex;
            flex-direction: column;
            min-height: calc(100svh - var(--header-height) - (var(--space-7) * 2));
        }

        .service-panel__cta {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            width: 100%;
            margin-top: auto;
            padding: 22px 0 0;
            border: 0;
            border-top: 1px solid rgba(255,255,255,.24);
            background: transparent;
            color: var(--foreground);
            cursor: pointer;
            text-align: left;
        }

        .service-panel__cta span {
            color: var(--muted);
            font-size: var(--type-label);
            font-weight: 500;
            letter-spacing: var(--tracking-label);
            text-transform: uppercase;
        }

        .service-panel__cta strong {
            font-size: clamp(20px, 1.8vw, 30px);
            font-weight: 500;
            line-height: 1;
            letter-spacing: -0.04em;
            transition: transform 300ms cubic-bezier(.22,1,.36,1);
        }

        .service-panel__cta:hover strong,
        .service-panel__cta:focus-visible strong {
            transform: translateX(8px);
        }

        .service-step {
            margin-inline: -22px;
            padding-inline: 22px;
            transition:
                opacity 480ms ease,
                transform 650ms cubic-bezier(0.22, 1, 0.36, 1),
                background-color 280ms ease,
                color 280ms ease,
                border-color 280ms ease;
        }

        .service-step__number,
        .service-step__description {
            transition: color 280ms ease;
        }

        @media (hover: hover) and (pointer: fine) {
            .service-step:hover {
                background: var(--foreground);
                color: var(--background);
                border-color: var(--foreground);
            }

            .service-step:hover .service-step__number,
            .service-step:hover .service-step__description {
                color: rgba(16,16,16,.68);
            }
        }

        .service-panel__cta--mobile {
            display: none;
        }

        /* The entrance stagger applies only to opacity and movement.
           Hover properties start immediately, without the old 160–440 ms delay. */
        .service-panel.is-open .service-step:nth-child(1) { transition-delay: 160ms, 160ms, 0ms, 0ms, 0ms; }
        .service-panel.is-open .service-step:nth-child(2) { transition-delay: 230ms, 230ms, 0ms, 0ms, 0ms; }
        .service-panel.is-open .service-step:nth-child(3) { transition-delay: 300ms, 300ms, 0ms, 0ms, 0ms; }
        .service-panel.is-open .service-step:nth-child(4) { transition-delay: 370ms, 370ms, 0ms, 0ms, 0ms; }
        .service-panel.is-open .service-step:nth-child(5) { transition-delay: 440ms, 440ms, 0ms, 0ms, 0ms; }

        @media (hover: hover) and (pointer: fine) {
            .service-step {
                will-change: background-color, color;
            }

            .service-step:hover {
                transition-duration: 480ms, 650ms, 420ms, 420ms, 420ms;
                transition-timing-function: ease, cubic-bezier(0.22, 1, 0.36, 1), cubic-bezier(0.22, 1, 0.36, 1), cubic-bezier(0.22, 1, 0.36, 1), cubic-bezier(0.22, 1, 0.36, 1);
            }

            .service-step__number,
            .service-step__description {
                transition-duration: 420ms;
                transition-timing-function: cubic-bezier(0.22, 1, 0.36, 1);
            }
        }

        @media (max-width: 820px) {
            .service-panel__intro {
                display: block;
                min-height: auto;
            }

            .service-panel__cta--desktop {
                display: none;
            }

            .service-panel__cta--mobile {
                display: flex;
                margin-top: 52px;
                padding-top: 18px;
            }

            .service-step {
                margin-inline: -16px;
                padding-inline: 16px;
            }
        }


/* === HERO HOVER IMAGES V14 === */
.hero-hover-stage{
 position:absolute;
 inset:0;
 pointer-events:none;
 z-index:1;
}
.hero-hover-image{
 position:absolute;
 width:min(34vw,420px);
 aspect-ratio:4/5;
 border-radius:0;
 overflow:hidden;
 opacity:0;
 transform:translate(-50%,-50%) scale(.96);
 transition:opacity .35s ease,transform .45s var(--motion-ease),left .45s var(--motion-ease),top .45s var(--motion-ease);
 will-change:transform,left,top;
}
.hero-hover-image img{
 width:100%;
 height:100%;
 object-fit:cover;
 display:block;
 opacity:.58;
}
.pillar{position:relative;z-index:5;}
.pillar[data-service="direction"]{--hx:50%;--hy:48%;}
.pillar[data-service="character"]{--hx:50%;--hy:48%;}
.pillar[data-service="presence"]{--hx:50%;--hy:48%;}


        /* Continuous services view */
        .service-continuation__header {
            align-self: start;
            margin-bottom: 0;
        }

        .service-continuation__header .service-panel__title {
            font-size: clamp(48px, 5.8vw, 96px);
        }

        .service-continuation__header .service-panel__lead {
            max-width: 760px;
        }

        .service-continuation__list {
            width: 100%;
        }

        @media (max-width: 820px) {
            .service-continuation__header {
                position: static;
                margin-bottom: 0;
            }
        }

        /* Continuous service sections */
        .service-panel {
            --service-bg: #111111;
            --service-fg: #ffffff;
            --service-muted: rgba(255, 255, 255, 0.62);
            background: var(--service-bg);
            color: var(--service-fg);
            transition:
                background-color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                opacity 420ms ease,
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s linear 700ms;
        }

        .service-panel.is-open {
            transition:
                background-color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                opacity 420ms ease,
                transform 700ms cubic-bezier(0.22, 1, 0.36, 1),
                visibility 0s;
        }

        .service-panel.is-inverted {
            --service-bg: #f2f0ea;
            --service-fg: #111111;
            --service-muted: rgba(17, 17, 17, 0.62);
        }

        .service-panel .service-panel__eyebrow,
        .service-panel .service-step__number,
        .service-panel .service-panel__lead,
        .service-panel .service-step__description,
        .service-panel .service-step__tagline {
            color: var(--service-muted);
            transition: color 700ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        .service-panel .service-step {
            border-color: color-mix(in srgb, var(--service-fg) 20%, transparent);
            transition:
                border-color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                color 700ms cubic-bezier(0.22, 1, 0.36, 1),
                opacity 480ms ease,
                transform 650ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        .service-panel__section,
        .service-continuation {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: minmax(300px, 0.9fr) minmax(0, 1.1fr);
            gap: clamp(70px, 10vw, 180px);
            width: 100%;
            min-height: 100svh;
            align-items: start;
            padding-block: clamp(24px, 4vh, 56px);
        }

        .service-panel__section + .service-continuation,
        .service-continuation + .service-continuation {
            margin-top: clamp(72px, 10vh, 130px);
            padding-top: clamp(72px, 9vh, 120px);
            border-top: 0;
        }

        @media (min-width: 821px) {
            .service-panel__section > .service-panel__intro,
            .service-continuation__header {
                position: sticky;
                top: calc(var(--header-height) + var(--space-6));
                align-self: start;
            }

            .service-panel__cta--desktop {
                display: none !important;
            }

            .service-panel__cta--mobile {
                grid-column: 1 / -1;
                width: 100%;
                margin-top: clamp(90px, 12vh, 160px);
            }
        }

        @media (max-width: 820px) {
            .service-panel__section,
            .service-continuation {
                grid-template-columns: 1fr;
                gap: 42px;
                min-height: auto;
            }
        }
</style>


<style id="inflect-final-detail-pass">
    :root {
        --page-gutter: clamp(18px, 2.5vw, 38px);
        --panel-gutter: clamp(20px, 4.2vw, 76px);
        --space-1: 8px;
        --space-2: 12px;
        --space-3: 16px;
        --space-4: 24px;
        --space-5: 32px;
        --space-6: 48px;
        --space-7: 64px;
        --space-8: 96px;
        --space-9: 128px;
        --type-label: 11px;
        --type-body: clamp(15px, 1vw, 17px);
        --type-body-large: clamp(18px, 1.35vw, 23px);
        --type-heading-small: clamp(25px, 2.15vw, 39px);
        --type-heading-medium: clamp(40px, 4.6vw, 76px);
        --type-display: clamp(48px, 5.3vw, 92px);
        --type-display-large: clamp(56px, 6.8vw, 110px);
        --tracking-label: .16em;
        --tracking-tight: -.045em;
        --tracking-display: -.058em;
        --leading-tight: .98;
        --leading-body: 1.45;
    }

    /* Shared rhythm */
    .bio-panel,
    .contact-panel {
        padding: calc(var(--header-height) + var(--space-6)) var(--page-gutter) var(--space-7);
    }

    .service-panel__inner {
        gap: clamp(72px, 9vw, 160px);
        padding: calc(var(--header-height) + var(--space-7)) var(--panel-gutter) var(--space-7);
    }

    .bio-panel__text,
    .contact-panel__headline,
    .service-panel__title,
    .pillar,
    .service-step__title,
    .team-member h3 {
        text-wrap: balance;
    }

    /* BIO hierarchy */
    .bio-panel__grid {
        grid-template-columns: minmax(0, 1.55fr) minmax(270px, .55fr);
        column-gap: clamp(72px, 10vw, 180px);
        row-gap: var(--space-8);
        align-items: end;
        margin-block: auto;
    }

    .bio-panel__text--manifest {
        max-width: 1100px;
        font-size: var(--type-heading-medium);
        line-height: var(--leading-tight);
        letter-spacing: var(--tracking-display);
    }

    .bio-panel__subsection {
        max-width: 900px;
        margin-top: clamp(72px, 8vw, 120px);
    }

    .bio-panel__text--secondary {
        font-size: clamp(28px, 2.55vw, 45px);
        line-height: 1.03;
        letter-spacing: -.048em;
    }

    .bio-panel__text--secondary p + p {
        margin-top: .95em;
    }

    .bio-panel__side {
        align-self: end;
        display: block;
        padding-bottom: 2px;
    }

    .bio-panel__side-block {
        max-width: 380px;
    }

    .bio-panel__side-text {
        font-size: var(--type-body-large);
        line-height: 1.25;
        letter-spacing: -.028em;
    }

    .team-layout {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: clamp(18px, 2.6vw, 42px);
        width: 100%;
        margin-top: var(--space-2);
    }

    .team-member {
        min-width: 0;
    }

    .team-member img {
        display: block;
        width: 100%;
        aspect-ratio: 1 / 1;
        height: auto;
        object-fit: cover;
    }

    .team-member h3 {
        margin: var(--space-3) 0 5px;
        font-size: clamp(20px, 1.65vw, 28px);
        font-weight: 500;
        line-height: 1;
        letter-spacing: -.035em;
    }

    .team-member p {
        color: var(--muted);
        font-size: clamp(12px, .9vw, 14px);
        line-height: 1.35;
        letter-spacing: -.01em;
    }

    /* Services */
    .service-panel__lead {
        max-width: 600px;
        margin-top: var(--space-5);
        font-size: var(--type-body-large);
        line-height: 1.25;
    }

    .service-step {
        grid-template-columns: 46px minmax(0, 1fr);
        gap: var(--space-4);
        padding-block: 30px 34px;
    }

    .service-step__title {
        margin-bottom: 9px;
        font-size: var(--type-heading-small);
        line-height: 1;
    }

    .service-step__tagline {
        margin-bottom: var(--space-3);
        color: var(--foreground);
        font-size: clamp(16px, 1.22vw, 20px);
        font-weight: 500;
        line-height: 1.2;
        letter-spacing: -.025em;
        transition: color 420ms cubic-bezier(.22,1,.36,1);
    }

    .service-step__description {
        max-width: 780px;
        font-size: var(--type-body);
        line-height: var(--leading-body);
    }

    @media (hover: hover) and (pointer: fine) {
        .service-step:hover .service-step__tagline {
            color: var(--background);
        }
    }

    /* Contact spacing */
    .contact-panel__grid {
        gap: clamp(72px, 8vw, 144px);
    }

    .contact-panel__meta {
        gap: var(--space-5);
        padding-top: var(--space-8);
    }

    .contact-form__field {
        margin-bottom: var(--space-5);
    }

    /* Projects — same composition, more air */
    .projects-panel__canvas {
        min-height: 9550px;
        padding-top: calc(var(--header-height) + 88px);
        padding-bottom: 180px;
    }

    .projects-panel__canvas img:nth-child(1){--y:170px}
    .projects-panel__canvas img:nth-child(2){--y:410px}
    .projects-panel__canvas img:nth-child(3){--y:840px}
    .projects-panel__canvas img:nth-child(4){--y:1320px}
    .projects-panel__canvas img:nth-child(5){--y:1530px}
    .projects-panel__canvas img:nth-child(6){--y:2020px}
    .projects-panel__canvas img:nth-child(7){--y:2240px}
    .projects-panel__canvas img:nth-child(8){--y:2670px}
    .projects-panel__canvas img:nth-child(9){--y:3220px}
    .projects-panel__canvas img:nth-child(10){--y:3440px}
    .projects-panel__canvas img:nth-child(11){--y:3910px}
    .projects-panel__canvas img:nth-child(12){--y:4280px}
    .projects-panel__canvas img:nth-child(13){--y:4640px}
    .projects-panel__canvas img:nth-child(14){--y:4890px}
    .projects-panel__canvas img:nth-child(15){--y:5480px}
    .projects-panel__canvas img:nth-child(16){--y:5680px}
    .projects-panel__canvas img:nth-child(17){--y:6110px}
    .projects-panel__canvas img:nth-child(18){--y:6700px}
    .projects-panel__canvas img:nth-child(19){--y:6910px}
    .projects-panel__canvas img:nth-child(20){--y:7330px}
    .projects-panel__canvas img:nth-child(21){--y:7750px}
    .projects-panel__canvas img:nth-child(22){--y:7960px}
    .projects-panel__canvas img:nth-child(23){--y:8420px}
    .projects-panel__canvas img:nth-child(24){--y:8750px}
    .projects-panel__canvas img:nth-child(25){--y:9110px}

    @media (max-width: 1000px) {
        .bio-panel__grid {
            grid-template-columns: 1fr;
            row-gap: var(--space-7);
        }

        .bio-panel__side-block {
            max-width: 680px;
        }
    }

    @media (max-width: 720px) {
        :root {
            --page-gutter: 16px;
            --panel-gutter: 16px;
            --space-8: 72px;
        }

        .bio-panel,
        .contact-panel {
            padding: calc(var(--header-height) + var(--space-5)) var(--page-gutter) var(--space-6);
        }

        .bio-panel__grid {
            row-gap: var(--space-6);
            align-content: start;
            margin-block: 0;
        }

        .bio-panel__text--manifest {
            font-size: clamp(33px, 9.2vw, 47px);
            line-height: 1;
        }

        .bio-panel__subsection {
            margin-top: var(--space-7);
        }

        .bio-panel__text--secondary {
            font-size: clamp(25px, 7.2vw, 35px);
            line-height: 1.03;
        }

        .bio-panel__side-text {
            max-width: 94%;
            font-size: 17px;
            line-height: 1.3;
        }

        .team-layout {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            margin-top: var(--space-2);
        }

        .team-member h3 {
            margin-top: 11px;
            font-size: clamp(15px, 4.4vw, 19px);
        }

        .team-member p {
            max-width: 110px;
            font-size: clamp(9px, 2.6vw, 11px);
            line-height: 1.25;
        }

        .service-step {
            grid-template-columns: 30px minmax(0, 1fr);
            gap: 14px;
            padding-block: 26px 30px;
        }

        .service-step__tagline {
            margin-bottom: 14px;
            font-size: 16px;
        }

        .projects-panel__canvas {
            min-height: 10100px;
            padding-top: calc(var(--header-height) + 58px);
        }

        .projects-panel__canvas img:nth-child(1){--y:120px}
        .projects-panel__canvas img:nth-child(2){--y:500px}
        .projects-panel__canvas img:nth-child(3){--y:880px}
        .projects-panel__canvas img:nth-child(4){--y:1260px}
        .projects-panel__canvas img:nth-child(5){--y:1640px}
        .projects-panel__canvas img:nth-child(6){--y:2020px}
        .projects-panel__canvas img:nth-child(7){--y:2400px}
        .projects-panel__canvas img:nth-child(8){--y:2780px}
        .projects-panel__canvas img:nth-child(9){--y:3160px}
        .projects-panel__canvas img:nth-child(10){--y:3540px}
        .projects-panel__canvas img:nth-child(11){--y:3920px}
        .projects-panel__canvas img:nth-child(12){--y:4300px}
        .projects-panel__canvas img:nth-child(13){--y:4680px}
        .projects-panel__canvas img:nth-child(14){--y:5060px}
        .projects-panel__canvas img:nth-child(15){--y:5440px}
        .projects-panel__canvas img:nth-child(16){--y:5820px}
        .projects-panel__canvas img:nth-child(17){--y:6200px}
        .projects-panel__canvas img:nth-child(18){--y:6580px}
        .projects-panel__canvas img:nth-child(19){--y:6960px}
        .projects-panel__canvas img:nth-child(20){--y:7340px}
        .projects-panel__canvas img:nth-child(21){--y:7720px}
        .projects-panel__canvas img:nth-child(22){--y:8100px}
        .projects-panel__canvas img:nth-child(23){--y:8480px}
        .projects-panel__canvas img:nth-child(24){--y:8860px}
        .projects-panel__canvas img:nth-child(25){--y:9240px}
    }
</style>


<style id="inflect-refinement-v2">
/* =========================================================
   INFLECT — NAV / SERVICE ALIGNMENT / SCALE REFINEMENT
========================================================= */

:root {
    --header-height: 116px;
    --type-label: 13px;
}

/* Navbar: larger, stacked vertically, with difference blending */
.topbar {
    height: var(--header-height);
    padding-inline: var(--page-gutter);
    align-items: flex-start;
    padding-top: 24px;
    mix-blend-mode: difference;
    color: #fff;
}

.topbar__studio {
    align-items: flex-start;
}

.topbar__studio img {
    height: 25px;
    width: auto;
}

.topbar__nav {
    flex-direction: column;
    align-items: flex-end;
    justify-content: flex-start;
    gap: 10px;
}

.topbar__bio,
.topbar__projects,
.topbar__contact {
    font-size: 13px;
    line-height: 1;
    letter-spacing: 0.14em;
}

.topbar__bio-label,
.topbar__projects-label,
.topbar__contact-label {
    text-align: right;
}

/* Service panels aligned exactly to navbar gutters */
.service-panel__inner {
    padding-left: var(--page-gutter);
    padding-right: var(--page-gutter);
}

/* Increase micro typography across service views */
.service-panel__eyebrow,
.service-step__number,
.service-panel__cta span,
.contact-panel__meta-label,
.contact-form__label,
.bio-panel__label,
.bio-panel__side-title {
    font-size: 13px;
}

.service-step__description {
    font-size: clamp(16px, 1.28vw, 20px);
}

.service-panel__lead {
    font-size: clamp(20px, 1.7vw, 28px);
}

.service-panel__cta strong {
    font-size: clamp(22px, 2vw, 32px);
}

/* Hero pillars equal in scale to service panel headings */
.pillar {
    font-size: var(--type-display-large);
    line-height: 0.9;
    letter-spacing: -0.065em;
    height: 0.94em;
}

.pillar__text {
    height: 0.94em;
}

/* Keep content clear below the taller navbar */
.hero {
    padding-top: var(--header-height);
}

.bio-panel,
.contact-panel {
    padding-top: calc(var(--header-height) + var(--space-5));
}

.service-panel__inner {
    padding-top: calc(var(--header-height) + var(--space-6));
}

.service-panel__intro {
    top: calc(var(--header-height) + var(--space-6));
}

.service-panel__close {
    top: 28px;
    right: var(--page-gutter);
    font-size: 13px;
    mix-blend-mode: difference;
    color: #fff;
}

@media (max-width: 720px) {
    :root {
        --header-height: 104px;
        --type-label: 11px;
    }

    .topbar {
        padding-top: 18px;
    }

    .topbar__studio img {
        height: 21px;
    }

    .topbar__nav {
        gap: 7px;
    }

    .topbar__bio,
    .topbar__projects,
    .topbar__contact {
        font-size: 11px;
        letter-spacing: 0.12em;
    }

    .service-panel__inner {
        padding-left: var(--page-gutter);
        padding-right: var(--page-gutter);
        padding-top: calc(var(--header-height) + var(--space-5));
    }

    .service-panel__eyebrow,
    .service-step__number,
    .service-panel__cta span,
    .contact-panel__meta-label,
    .contact-form__label,
    .bio-panel__label,
    .bio-panel__side-title {
        font-size: 11px;
    }

    .service-step__description {
        font-size: 16px;
    }

    .pillar {
        font-size: clamp(52px, 16vw, 82px);
        line-height: 0.9;
        height: 0.94em;
    }

    .pillar__text {
        height: 0.94em;
    }
}
</style>


<style id="inflect-hero-spacing-v3">
/* Więcej oddechu między filarami w hero — desktop */
@media (min-width: 901px) {
    .pillars {
        column-gap: clamp(48px, 5vw, 110px);
        max-width: 1760px;
    }

    .hero__content {
        padding-left: clamp(36px, 5vw, 96px);
        padding-right: clamp(36px, 5vw, 96px);
    }
}
</style>


<style id="inflect-routing-hero-service-loop-v4">
/* =========================================================
   HERO — TRUE VIEWPORT CENTER + SAFE ANIMATED LABELS
========================================================= */

:root {
    /* Keeps hero pillars and service headings on the same scale,
       while allowing all three pillars to fit comfortably. */
    --type-display-large: clamp(56px, 5.7vw, 112px);
}

.hero {
    position: relative;
    display: block;
    min-height: 100svh;
    padding: 0;
    overflow: hidden;
}

.hero__content {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 100svh;
    padding: clamp(28px, 4vw, 72px) var(--page-gutter);
    pointer-events: none;
}

.pillars {
    display: grid;
    grid-template-columns: repeat(3, max-content);
    justify-content: center;
    align-items: center;
    column-gap: clamp(44px, 4.6vw, 104px);
    width: auto;
    max-width: calc(100vw - (var(--page-gutter) * 2));
    margin: 0;
    pointer-events: auto;
}

.pillar {
    width: max-content;
    min-width: 0;
    height: 1.18em;
    padding-inline: 0.04em;
    overflow: hidden;
    font-size: var(--type-display-large);
    line-height: 1.08;
}

.pillar__sizer {
    height: 1.18em;
    line-height: 1.08;
}

.pillar__track {
    top: 0;
}

.pillar__text {
    height: 1.18em;
    line-height: 1.08;
    padding-bottom: 0.08em;
}

/* Logos remain independent at the bottom and do not affect hero centering. */
.logos {
    position: absolute;
    left: 0;
    right: 0;
    bottom: var(--space-5);
    z-index: 1;
}

/* =========================================================
   SERVICE LOOP NAVIGATION
========================================================= */

.service-loop {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    margin-top: clamp(64px, 8vw, 120px);
    border-top: 1px solid rgba(255,255,255,.22);
    border-bottom: 1px solid rgba(255,255,255,.22);
}

.service-loop__button {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    min-height: 132px;
    padding: 24px 22px 26px;
    border: 0;
    background: transparent;
    color: var(--foreground);
    cursor: pointer;
    text-align: left;
    transition:
        background-color 360ms cubic-bezier(.22,1,.36,1),
        color 360ms cubic-bezier(.22,1,.36,1);
}

.service-loop__button + .service-loop__button {
    border-left: 1px solid rgba(255,255,255,.22);
}

.service-loop__label {
    font-size: clamp(25px, 2.3vw, 42px);
    font-weight: 500;
    line-height: .96;
    letter-spacing: -.045em;
}

.service-loop__arrow {
    flex: 0 0 auto;
    font-size: 22px;
    line-height: 1;
    transition: transform 300ms cubic-bezier(.22,1,.36,1);
}

@media (hover: hover) and (pointer: fine) {
    .service-loop__button:hover,
    .service-loop__button:focus-visible {
        background: var(--foreground);
        color: var(--background);
    }

    .service-loop__button:hover .service-loop__arrow,
    .service-loop__button:focus-visible .service-loop__arrow {
        transform: translateX(7px);
    }
}

/* =========================================================
   RESPONSIVE HERO
========================================================= */

@media (max-width: 1180px) and (min-width: 721px) {
    :root {
        --type-display-large: clamp(54px, 5.6vw, 76px);
    }

    .pillars {
        column-gap: clamp(28px, 3.2vw, 48px);
    }
}

@media (max-width: 720px) {
    :root {
        --type-display-large: clamp(48px, 13.5vw, 72px);
    }

    .hero {
        min-height: 100svh;
        padding: 0;
    }

    .hero__content {
        inset: 0;
        min-height: 100svh;
        padding: var(--header-height) var(--page-gutter) 96px;
    }

    .pillars {
        grid-template-columns: 1fr;
        justify-items: center;
        row-gap: 4px;
        width: 100%;
        max-width: 100%;
    }

    .pillar {
        width: max-content;
        max-width: 100%;
        height: 1.2em;
        font-size: var(--type-display-large);
        line-height: 1.08;
    }

    .pillar__sizer,
    .pillar__text {
        height: 1.2em;
        line-height: 1.08;
        padding-bottom: 0.09em;
    }

    .logos {
        bottom: var(--space-4);
    }

    .service-loop {
        grid-template-columns: 1fr;
        margin-top: 64px;
    }

    .service-loop__button {
        min-height: 104px;
        padding: 22px 16px 24px;
    }

    .service-loop__button + .service-loop__button {
        border-left: 0;
        border-top: 1px solid rgba(255,255,255,.22);
    }

    .service-loop__label {
        font-size: clamp(27px, 8vw, 38px);
    }
}
</style>


<style id="inflect-contact-projects-loop-v5">
/* =========================================================
   CONTACT — DESKTOP ALIGNMENT / MOBILE ORDER
========================================================= */

.contact-panel__grid {
    grid-template-areas:
        "headline form"
        "meta form";
    grid-template-columns:
        minmax(0, 1fr)
        minmax(420px, .92fr);
    align-items: start;
}

.contact-panel__intro {
    display: contents;
}

.contact-panel__headline {
    grid-area: headline;
    align-self: start;
    margin: 0;
}

.contact-panel__meta {
    grid-area: meta;
    align-self: end;
}

.contact-panel__form-wrap {
    grid-area: form;
    align-items: flex-start;
    padding-top: 0;
}

.contact-form {
    margin-top: 0;
}

/* =========================================================
   SHARED ARROWS + END CTAs
========================================================= */

.nav-arrow {
    display: inline-block;
    margin-left: .18em;
    font-family: inherit;
    font-size: .88em;
    font-weight: inherit;
    line-height: 1;
    vertical-align: .04em;
    transition: transform 300ms cubic-bezier(.22,1,.36,1);
}

.service-panel__cta:hover .nav-arrow,
.service-panel__cta:focus-visible .nav-arrow,
.service-loop__button:hover .nav-arrow,
.service-loop__button:focus-visible .nav-arrow,
.panel-end-cta__button:hover .nav-arrow,
.panel-end-cta__button:focus-visible .nav-arrow {
    transform: translate(5px, -5px);
}

.service-loop__arrow {
    font-size: 22px;
}

.panel-end-cta {
    width: 100%;
    margin-top: clamp(72px, 10vw, 150px);
}

.panel-end-cta__button {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    width: 100%;
    padding: 24px 0 28px;
    border: 0;
    border-top: 1px solid rgba(255,255,255,.24);
    background: transparent;
    color: var(--foreground);
    cursor: pointer;
    text-align: left;
}

.panel-end-cta__eyebrow {
    color: var(--muted);
    font-size: 13px;
    font-weight: 500;
    line-height: 1;
    letter-spacing: var(--tracking-label);
    text-transform: uppercase;
}

.panel-end-cta__title {
    font-size: clamp(28px, 3.6vw, 64px);
    font-weight: 500;
    line-height: .95;
    letter-spacing: -.05em;
}

/* BIO needs natural document flow for an end CTA. */
.bio-panel {
    display: block;
}

.bio-panel__grid {
    min-height: calc(100svh - var(--header-height) - 96px);
}

.bio-panel__end-cta {
    margin-top: clamp(90px, 12vw, 180px);
    padding-bottom: 20px;
}

/* =========================================================
   PROJECTS — DYNAMIC CANVAS HEIGHT + LOOP FOOTER
========================================================= */

.projects-panel__canvas {
    min-height: 0;
}

.projects-panel__footer {
    position: relative;
    z-index: 3;
    padding:
        clamp(110px, 13vw, 220px)
        var(--page-gutter)
        clamp(52px, 7vw, 96px);
}

.projects-panel__footer-pillars {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    align-items: center;
    gap: clamp(40px, 5vw, 100px);
    margin-bottom: clamp(96px, 12vw, 190px);
    font-size: var(--type-display-large);
    font-weight: 600;
    line-height: .9;
    letter-spacing: -.065em;
    text-align: center;
}

.projects-panel__cta {
    padding-left: 0;
    padding-right: 0;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 720px) {
    .contact-panel__grid {
        grid-template-areas:
            "headline"
            "form"
            "meta";
        grid-template-columns: 1fr;
        gap: 0;
    }

    .contact-panel__headline {
        margin-bottom: 56px;
    }

    .contact-panel__form-wrap {
        margin-bottom: 72px;
    }

    .contact-panel__meta {
        grid-template-columns: 1fr;
        gap: 28px;
        padding-top: 0;
    }

    .panel-end-cta__button {
        align-items: flex-end;
        padding: 20px 0 24px;
    }

    .panel-end-cta__eyebrow {
        font-size: 11px;
    }

    .panel-end-cta__title {
        font-size: clamp(27px, 8.5vw, 40px);
    }

    .service-loop__arrow,
    .nav-arrow {
        font-size: .88em;
    }

    .bio-panel__grid {
        min-height: auto;
    }

    .bio-panel__end-cta {
        margin-top: 84px;
    }

    .projects-panel__footer {
        padding:
            96px
            var(--page-gutter)
            44px;
    }

    .projects-panel__footer-pillars {
        grid-template-columns: 1fr;
        gap: 5px;
        margin-bottom: 96px;
        font-size: clamp(48px, 13.5vw, 72px);
    }
}
</style>


<style id="inflect-motion-system-v6">
/* =========================================================
   INTRO — LOGO MORPH INTO NAVBAR
========================================================= */

.site-intro {
    position: fixed;
    inset: 0;
    z-index: 5000;
    background: var(--background);
    overflow: hidden;
    pointer-events: none;
    opacity: 1;
    visibility: visible;
}

.site-intro__logo {
    position: fixed;
    left: 50%;
    top: 50%;
    display: block;
    width: min(58vw, 620px);
    height: auto;
    opacity: 0;
    transform: translate(-50%, -50%) scale(.94);
    transform-origin: center center;
    will-change: left, top, width, transform, opacity;
}

body.intro-is-running {
    overflow: hidden;
}

body.intro-is-running .topbar__studio {
    opacity: 0;
}

body.intro-is-running .topbar__nav,
body.intro-is-running .hero__content,
body.intro-is-running .logos {
    opacity: 0;
    transform: translateY(10px);
}

.topbar__studio,
.topbar__nav,
.hero__content,
.logos {
    transition:
        opacity 650ms cubic-bezier(.22,1,.36,1),
        transform 650ms cubic-bezier(.22,1,.36,1);
}

body.intro-elements-visible .topbar__nav,
body.intro-elements-visible .hero__content,
body.intro-elements-visible .logos {
    opacity: 1;
    transform: translateY(0);
}

.site-intro.is-visible .site-intro__logo {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
    transition:
        opacity 700ms ease,
        transform 900ms cubic-bezier(.22,1,.36,1);
}

.site-intro.is-moving .site-intro__logo {
    transition:
        left 1050ms cubic-bezier(.76,0,.24,1),
        top 1050ms cubic-bezier(.76,0,.24,1),
        width 1050ms cubic-bezier(.76,0,.24,1),
        transform 1050ms cubic-bezier(.76,0,.24,1);
}

.site-intro.is-revealing {
    background: transparent;
    transition: background-color 180ms ease;
}

.site-intro.is-finished {
    opacity: 0;
    visibility: hidden;
    transition:
        opacity 240ms ease,
        visibility 0s linear 240ms;
}

/* =========================================================
   SERVICE CONTENT TRANSITIONS
========================================================= */

.service-panel__intro,
.service-panel__list {
    transition:
        opacity 260ms ease,
        transform 420ms cubic-bezier(.22,1,.36,1);
}

.service-panel.is-switching .service-panel__intro,
.service-panel.is-switching .service-panel__list {
    opacity: 0;
    transform: translateY(18px);
}

.service-panel.is-entering .service-panel__intro,
.service-panel.is-entering .service-panel__list {
    animation: serviceContentEnter 620ms cubic-bezier(.22,1,.36,1) both;
}

.service-panel.is-entering .service-panel__list {
    animation-delay: 70ms;
}

@keyframes serviceContentEnter {
    from {
        opacity: 0;
        transform: translateY(22px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================================
   BIO STATEMENT
========================================================= */

.bio-statement__old,
.bio-statement__new {
    display: block;
}

.bio-statement__old {
    position: relative;
    width: fit-content;
}

.bio-statement__old::after {
    content: "";
    position: absolute;
    left: 0;
    top: 54%;
    width: 100%;
    height: .075em;
    background: currentColor;
    transform: scaleX(0);
    transform-origin: left center;
}

.bio-statement__new {
    margin-top: .12em;
    opacity: 0;
    transform: translateY(.28em);
}

.bio-panel.is-open .bio-statement__old::after {
    animation: bioStrike 720ms 480ms cubic-bezier(.22,1,.36,1) forwards;
}

.bio-panel.is-open .bio-statement__new {
    animation: bioNewLine 680ms 980ms cubic-bezier(.22,1,.36,1) forwards;
}

@keyframes bioStrike {
    to { transform: scaleX(1); }
}

@keyframes bioNewLine {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================================================
   PROJECT FOOTER — SAME MOTIF AS HERO
========================================================= */

.projects-panel__footer-pillars {
    grid-template-columns: repeat(3, max-content);
    justify-content: center;
    align-items: center;
}

.footer-pillar {
    position: relative;
    width: max-content;
    height: 1.2em;
    padding-inline: .04em;
    border: 0;
    overflow: hidden;
    background: transparent;
    color: inherit;
    cursor: pointer;
    font: inherit;
    font-size: var(--type-display-large);
    font-weight: 600;
    line-height: 1.08;
    letter-spacing: -.065em;
    text-align: center;
}

.footer-pillar__sizer {
    display: block;
    height: 1.2em;
    visibility: hidden;
    white-space: nowrap;
}

.footer-pillar__track {
    position: absolute;
    top: 0;
    left: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: max-content;
    transform: translate(-50%, 0);
    transition: transform var(--transition);
}

.footer-pillar__text {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 1.2em;
    padding-bottom: .09em;
    white-space: nowrap;
}

.footer-pillar:hover .footer-pillar__track,
.footer-pillar:focus-visible .footer-pillar__track {
    transform: translate(-50%, -50%);
}

.footer-pillar:focus-visible {
    outline: 1px solid currentColor;
    outline-offset: 8px;
}

/* =========================================================
   FONT-SAFE 45° ARROW — NO EMOJI
========================================================= */

.nav-arrow {
    position: relative;
    display: inline-block;
    width: .72em;
    height: .72em;
    margin-left: .22em;
    font-size: inherit;
    vertical-align: .02em;
    transform: translateZ(0);
}

.nav-arrow::before {
    content: "";
    position: absolute;
    left: .08em;
    bottom: .08em;
    width: .78em;
    height: 1.5px;
    background: currentColor;
    transform: rotate(-45deg);
    transform-origin: center;
}

.nav-arrow::after {
    content: "";
    position: absolute;
    top: .02em;
    right: .02em;
    width: .42em;
    height: .42em;
    border-top: 1.5px solid currentColor;
    border-right: 1.5px solid currentColor;
}

.service-loop__arrow {
    width: .8em;
    height: .8em;
    font-size: 22px;
}

.service-panel__cta:hover .nav-arrow,
.service-panel__cta:focus-visible .nav-arrow,
.service-loop__button:hover .nav-arrow,
.service-loop__button:focus-visible .nav-arrow,
.panel-end-cta__button:hover .nav-arrow,
.panel-end-cta__button:focus-visible .nav-arrow {
    transform: translate(5px, -5px);
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 720px) {
    .site-intro__logo {
        width: min(72vw, 390px);
    }

        100% {
            opacity: 1;
            transform:
                translate(
                    calc(-50vw + var(--page-gutter) + 50%),
                    calc(-50svh + 18px + 50%)
                )
                scale(.13);
        }
    }

    .projects-panel__footer-pillars {
        grid-template-columns: 1fr;
        justify-items: center;
        gap: 4px;
    }

    .footer-pillar {
        font-size: clamp(48px, 13.5vw, 72px);
    }

    .nav-arrow::before,
    .nav-arrow::after {
        backface-visibility: hidden;
    }
}

@media (prefers-reduced-motion: reduce) {
    .site-intro {
        display: none;
    }

    .service-panel__intro,
    .service-panel__list,
    .bio-statement__old::after,
    .bio-statement__new {
        animation: none !important;
        transition: none !important;
    }

    .bio-statement__old::after {
        transform: scaleX(1);
    }

    .bio-statement__new {
        opacity: 1;
        transform: none;
    }
}
</style>


<style id="inflect-intro-mobile-v7">
@media (max-width: 720px) {
    .site-intro__logo {
        width: min(76vw, 420px);
    }
}
</style>


<style id="inflect-unified-motion-v8">
/* =========================================================
   GLOBAL MOTION LANGUAGE
========================================================= */

:root {
    --motion-ease: cubic-bezier(.22,1,.36,1);
    --motion-fast: 280ms;
    --motion-medium: 560ms;
    --motion-slow: 760ms;
}

/* Menu pages no longer slide down like dropdowns. */
.bio-panel,
.projects-panel,
.contact-panel {
    opacity: 0 !important;
    transform: translateY(28px) !important;
    visibility: hidden;
    transition:
        opacity 420ms ease,
        transform 700ms var(--motion-ease),
        visibility 0s linear 700ms !important;
    will-change: opacity, transform;
}

.bio-panel.is-open,
.projects-panel.is-open,
.contact-panel.is-open {
    opacity: 1 !important;
    transform: translateY(0) !important;
    visibility: visible;
    transition:
        opacity 420ms ease,
        transform 700ms var(--motion-ease),
        visibility 0s !important;
}

/* Internal page content uses the same entrance logic as service views. */
.bio-panel.is-entering .bio-panel__label,
.bio-panel.is-entering .bio-panel__text--manifest,
.bio-panel.is-entering .bio-panel__subsection,
.bio-panel.is-entering .bio-panel__side,
.bio-panel.is-entering .team-layout,
.bio-panel.is-entering .bio-panel__end-cta,
.contact-panel.is-entering .contact-panel__headline,
.contact-panel.is-entering .contact-panel__form-wrap,
.contact-panel.is-entering .contact-panel__meta,
.projects-panel.is-entering .projects-panel__canvas,
.projects-panel.is-entering .projects-panel__footer {
    animation: unifiedContentEnter 680ms var(--motion-ease) both;
}

.bio-panel.is-entering .bio-panel__text--manifest { animation-delay: 70ms; }
.bio-panel.is-entering .bio-panel__subsection { animation-delay: 140ms; }
.bio-panel.is-entering .bio-panel__side { animation-delay: 210ms; }
.bio-panel.is-entering .team-layout { animation-delay: 280ms; }
.bio-panel.is-entering .bio-panel__end-cta { animation-delay: 350ms; }

.contact-panel.is-entering .contact-panel__headline { animation-delay: 70ms; }
.contact-panel.is-entering .contact-panel__form-wrap { animation-delay: 150ms; }
.contact-panel.is-entering .contact-panel__meta { animation-delay: 230ms; }

.projects-panel.is-entering .projects-panel__canvas { animation-delay: 60ms; }
.projects-panel.is-entering .projects-panel__footer { animation-delay: 180ms; }

.projects-panel.is-entering .projects-panel__canvas img:nth-child(-n+6) {
    animation: projectImageEnter 760ms var(--motion-ease) both;
}

.projects-panel.is-entering .projects-panel__canvas img:nth-child(1) { animation-delay: 100ms; }
.projects-panel.is-entering .projects-panel__canvas img:nth-child(2) { animation-delay: 170ms; }
.projects-panel.is-entering .projects-panel__canvas img:nth-child(3) { animation-delay: 240ms; }
.projects-panel.is-entering .projects-panel__canvas img:nth-child(4) { animation-delay: 310ms; }
.projects-panel.is-entering .projects-panel__canvas img:nth-child(5) { animation-delay: 380ms; }
.projects-panel.is-entering .projects-panel__canvas img:nth-child(6) { animation-delay: 450ms; }

@keyframes unifiedContentEnter {
    from {
        opacity: 0;
        transform: translateY(22px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes projectImageEnter {
    from {
        opacity: 0;
        transform: translateY(28px) scale(.985);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   HOME — DIRECTIONAL REVEAL AFTER LOGO MORPH
========================================================= */

/* Keep wrappers rendered while individual groups animate. */
body.intro-is-running .topbar__nav,
body.intro-is-running .hero__content,
body.intro-is-running .logos {
    opacity: 1 !important;
    transform: none !important;
}

/* Menu starts above the viewport. */
body.intro-is-running .topbar__nav {
    transform: translateY(-34px) !important;
    opacity: 0 !important;
}

/* Client logos start below the viewport. */
body.intro-is-running .logos {
    transform: translateY(42px) !important;
    opacity: 0 !important;
}

/* Hero pillars start lower and reveal one by one. */
body.intro-is-running .pillar {
    opacity: 0;
    transform: translateY(24px);
}

/* Menu and logos move at the same time. */
body.intro-elements-visible .topbar__nav {
    opacity: 1 !important;
    transform: translateY(0) !important;
    transition:
        opacity 700ms ease,
        transform 900ms var(--motion-ease);
}

body.intro-elements-visible .logos {
    opacity: 1 !important;
    transform: translateY(0) !important;
    transition:
        opacity 700ms ease,
        transform 900ms var(--motion-ease);
}

/* Hero sequence is controlled explicitly by JS.
   This avoids competing transition delays and guarantees:
   Kierunek → Charakter → Obecność. */
body.intro-is-running .pillar {
    opacity: 0;
    transform: translateY(24px);
    transition:
        opacity 650ms ease,
        transform 820ms var(--motion-ease);
}

body.intro-is-running .pillar.is-intro-revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Re-entering home from internal views follows the same choreography. */
body.home-is-entering .topbar__nav {
    animation: homeMenuEnter 820ms var(--motion-ease) both;
}

body.home-is-entering .logos {
    animation: homeLogosEnter 820ms var(--motion-ease) both;
}

body.home-is-entering .pillar {
    animation: homePillarEnter 760ms var(--motion-ease) both;
}

body.home-is-entering .pillar:nth-child(1) { animation-delay: 900ms; }
body.home-is-entering .pillar:nth-child(2) { animation-delay: 1900ms; }
body.home-is-entering .pillar:nth-child(3) { animation-delay: 2900ms; }

@keyframes homeMenuEnter {
    from {
        opacity: 0;
        transform: translateY(-34px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes homeLogosEnter {
    from {
        opacity: 0;
        transform: translateY(42px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes homePillarEnter {
    from {
        opacity: 0;
        transform: translateY(24px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Opening and closing should feel like one coherent scene change. */
.bio-panel.is-leaving,
.projects-panel.is-leaving,
.contact-panel.is-leaving,
.service-panel.is-leaving {
    opacity: 0 !important;
    transform: translateY(-16px) !important;
    transition:
        opacity 260ms ease,
        transform 420ms var(--motion-ease) !important;
}

/* Ensure animations replay each time without stale states. */
.bio-panel:not(.is-open),
.projects-panel:not(.is-open),
.contact-panel:not(.is-open) {
    pointer-events: none;
}

@media (max-width: 720px) {
    body.intro-is-running .pillar {
        transform: translateY(18px);
    }

.projects-panel.is-entering .projects-panel__canvas img:nth-child(n+5) {
        animation: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .bio-panel,
    .projects-panel,
    .contact-panel,
    .bio-panel *,
    .projects-panel *,
    .contact-panel *,
    .topbar__nav > button,
    .pillar,
    .logos {
        animation: none !important;
        transition-duration: 1ms !important;
    }
}
</style>


<style id="inflect-bio-copy-update">
/* BIO copy hierarchy — content update */
.bio-panel__text--secondary {
    max-width: 980px;
}

.bio-panel__text--secondary p + p {
    margin-top: 1.12em;
}

.bio-panel__side-text p + p {
    margin-top: .72em;
}

.bio-panel__side-text strong {
    color: var(--foreground);
    font-weight: 500;
}

@media (max-width: 720px) {
    .bio-panel__text--secondary p + p {
        margin-top: 1em;
    }

    .bio-panel__side {
        margin-top: var(--space-2);
    }
}
</style>


<style id="inflect-bio-hierarchy-v2">
/* BIO — restored hierarchy and use of space */
@media (min-width: 1001px) {
    .bio-panel {
        padding-bottom: clamp(52px, 6vh, 88px);
    }

    .bio-panel__grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        grid-template-rows: auto auto auto auto;
        column-gap: clamp(22px, 2.4vw, 42px);
        row-gap: 0;
        min-height: calc(100svh - var(--header-height) - var(--space-5) - clamp(52px, 6vh, 88px));
        align-content: space-between;
        align-items: end;
        margin: 0;
    }

    .bio-panel__main {
        display: contents;
    }

    .bio-panel__text--manifest {
        grid-column: 1 / 9;
        grid-row: 1;
        max-width: 1030px;
        font-size: clamp(56px, 5.1vw, 92px);
        line-height: .94;
        letter-spacing: -.064em;
    }

    .bio-panel__copy-pair {
        grid-column: 1 / 10;
        grid-row: 2;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, .86fr);
        gap: clamp(56px, 7vw, 128px);
        max-width: 1180px;
        padding-block: clamp(54px, 7vh, 90px);
        font-size: clamp(21px, 1.65vw, 30px);
        line-height: 1.12;
        letter-spacing: -.035em;
    }

    .bio-panel__copy-pair p {
        max-width: 520px;
    }

    .bio-panel__foundation {
        grid-column: 1 / 8;
        grid-row: 3;
        align-self: end;
        max-width: 800px;
    }

    .bio-panel__foundation .bio-statement {
        font-size: clamp(31px, 2.75vw, 50px);
        line-height: 1.02;
        letter-spacing: -.05em;
    }

    .bio-panel__team-copy {
        max-width: 720px;
        margin-top: clamp(34px, 4.5vh, 58px);
        font-size: clamp(27px, 2.3vw, 42px);
        line-height: 1.04;
        letter-spacing: -.047em;
    }

    .bio-panel__side {
        grid-column: 10 / 13;
        grid-row: 3;
        align-self: end;
        padding: 0 0 4px;
    }

    .bio-panel__side-block {
        max-width: 360px;
        margin-left: auto;
    }

    .bio-panel__side-text {
        font-size: clamp(17px, 1.18vw, 22px);
        line-height: 1.28;
        letter-spacing: -.022em;
    }

    .bio-panel__side-text p + p {
        margin-top: 1.05em;
    }

    .team-layout {
        grid-column: 1 / -1;
        grid-row: 4;
        margin-top: clamp(120px, 16vh, 220px);
    }
}

@media (max-width: 1000px) {
    .bio-panel__main {
        display: block;
    }

    .bio-panel__copy-pair {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 34px;
        margin-top: 58px;
        font-size: clamp(20px, 2.5vw, 27px);
        line-height: 1.18;
        letter-spacing: -.03em;
    }

    .bio-panel__foundation {
        margin-top: 70px;
    }

    .bio-panel__foundation .bio-statement {
        font-size: clamp(29px, 4vw, 42px);
        line-height: 1.04;
    }

    .bio-panel__team-copy {
        max-width: 720px;
        margin-top: 40px;
        font-size: clamp(25px, 3.6vw, 36px);
        line-height: 1.06;
        letter-spacing: -.04em;
    }
}

@media (max-width: 720px) {
    .bio-panel__copy-pair {
        grid-template-columns: 1fr;
        gap: 28px;
        margin-top: 44px;
        font-size: 19px;
    }

    .bio-panel__foundation {
        margin-top: 54px;
    }

    .bio-panel__foundation .bio-statement {
        font-size: clamp(27px, 7.5vw, 35px);
    }

    .bio-panel__team-copy {
        margin-top: 34px;
        font-size: clamp(24px, 7vw, 33px);
    }

    .bio-panel__side {
        margin-top: 52px;
    }
}
</style>


<style id="inflect-bio-color-rhythm-v3">
/* BIO — final hierarchy, colour rhythm and spatial composition */
.bio-panel__text--manifest {
    color: var(--foreground);
}

.bio-panel__copy-pair p:first-child {
    color: var(--muted);
}

.bio-panel__copy-pair p:last-child {
    color: var(--foreground);
}

.bio-panel__foundation .bio-statement__old {
    color: rgba(255, 255, 255, .58);
}

.bio-panel__foundation .bio-statement__new {
    color: var(--foreground);
}

.bio-panel__team-copy {
    color: var(--muted);
}

.bio-panel__side-text strong {
    color: var(--foreground);
}

.bio-panel__side-text p:not(:first-child) {
    color: var(--muted);
}

@media (min-width: 1001px) {
    .bio-panel__copy-pair {
        grid-column: 1 / 11;
        grid-template-columns: minmax(0, .92fr) minmax(0, .78fr);
        gap: clamp(88px, 10vw, 180px);
        max-width: 1280px;
        padding-top: clamp(68px, 8vh, 112px);
        padding-bottom: clamp(92px, 11vh, 150px);
    }

    .bio-panel__copy-pair p:first-child {
        max-width: 540px;
        line-height: 1.18;
    }

    .bio-panel__copy-pair p:last-child {
        max-width: 500px;
        transform: translateX(clamp(18px, 2.6vw, 48px));
        line-height: 1.12;
    }

    .bio-panel__foundation {
        grid-column: 1 / 8;
        max-width: 790px;
    }

    .bio-panel__foundation .bio-statement {
        max-width: 690px;
    }

    .bio-panel__foundation .bio-statement__old,
    .bio-panel__foundation .bio-statement__new {
        display: block;
    }

    .bio-panel__foundation .bio-statement__new {
        max-width: 640px;
        margin-top: .18em;
    }

    .bio-panel__team-copy {
        max-width: 680px;
        margin-top: clamp(58px, 6.5vh, 90px);
        font-size: clamp(25px, 2vw, 36px);
        line-height: 1.1;
    }

    .bio-panel__side {
        grid-column: 10 / 13;
        padding-bottom: 8px;
    }

    .bio-panel__side-text {
        color: var(--muted);
    }

    .bio-panel__side-text strong {
        display: block;
        margin-bottom: 1.15em;
    }
}

@media (max-width: 1000px) {
    .bio-panel__copy-pair {
        gap: clamp(34px, 6vw, 72px);
        margin-top: clamp(54px, 8vw, 86px);
    }

    .bio-panel__copy-pair p:last-child {
        transform: translateY(18px);
    }

    .bio-panel__foundation {
        margin-top: clamp(82px, 11vw, 124px);
    }

    .bio-panel__foundation .bio-statement__old,
    .bio-panel__foundation .bio-statement__new {
        display: block;
    }

    .bio-panel__foundation .bio-statement__new {
        margin-top: .18em;
    }

    .bio-panel__team-copy {
        margin-top: clamp(52px, 7vw, 78px);
    }
}

@media (max-width: 720px) {
    .bio-panel__copy-pair p:last-child {
        transform: none;
    }

    .bio-panel__foundation {
        margin-top: 68px;
    }

    .bio-panel__team-copy {
        margin-top: 46px;
    }

    .bio-panel__side-text strong {
        display: block;
        margin-bottom: .9em;
    }
}
</style>


<style id="inflect-bio-final-layout-v4">
/* BIO — composition matched to approved desktop reference */
@media (min-width: 1001px) {
    .bio-panel {
        padding-top: calc(var(--header-height) + 10px);
        padding-bottom: clamp(40px, 5vh, 70px);
    }

    .bio-panel__grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        grid-template-rows: auto 1fr auto;
        column-gap: clamp(22px, 2.25vw, 42px);
        row-gap: 0;
        min-height: calc(100svh - var(--header-height) - 10px - clamp(40px, 5vh, 70px));
        margin: 0;
        align-items: start;
        align-content: stretch;
    }

    .bio-panel__main { display: contents; }

    .bio-panel__text--manifest {
        grid-column: 1 / 7;
        grid-row: 1;
        align-self: start;
        max-width: 920px;
        font-size: clamp(58px, 4.75vw, 92px);
        line-height: .94;
        letter-spacing: -.064em;
    }

    .bio-panel__copy-pair {
        grid-column: 7 / 11;
        grid-row: 2;
        align-self: center;
        display: block;
        width: 100%;
        max-width: 560px;
        padding: 0;
        margin: clamp(-18px, -1.2vh, -8px) 0 0;
        font-size: clamp(20px, 1.35vw, 27px);
        line-height: 1.17;
        letter-spacing: -.03em;
    }

    .bio-panel__copy-pair p {
        max-width: 540px;
    }

    .bio-panel__copy-pair p:first-child {
        color: var(--muted);
    }

    .bio-panel__copy-pair p:last-child {
        max-width: 500px;
        margin-top: clamp(28px, 3.2vh, 44px);
        transform: none;
        color: var(--foreground);
        line-height: 1.12;
    }

    .bio-panel__foundation {
        grid-column: 1 / 8;
        grid-row: 3;
        align-self: end;
        max-width: 980px;
        margin: 0;
        padding-bottom: 2px;
    }

    .bio-panel__foundation .bio-statement {
        max-width: none;
        font-size: clamp(31px, 2.35vw, 46px);
        line-height: 1.03;
        letter-spacing: -.048em;
    }

    .bio-panel__foundation .bio-statement__old {
        display: block;
        width: fit-content;
        color: rgba(255,255,255,.54);
    }

    .bio-panel__foundation .bio-statement__new {
        display: block;
        max-width: none;
        width: max-content;
        margin-top: .20em;
        white-space: nowrap;
        color: var(--foreground);
    }

    .bio-panel__team-copy {
        max-width: 690px;
        margin-top: clamp(38px, 5vh, 66px);
        color: var(--muted);
        font-size: clamp(22px, 1.7vw, 34px);
        line-height: 1.09;
        letter-spacing: -.04em;
    }

    .bio-panel__side {
        grid-column: 10 / 13;
        grid-row: 3;
        align-self: end;
        padding: 0 0 6px;
    }

    .bio-panel__side-block {
        max-width: 330px;
        margin-left: auto;
    }

    .bio-panel__side-text {
        font-size: clamp(15px, .98vw, 19px);
        line-height: 1.3;
        letter-spacing: -.018em;
    }

    .bio-panel__side-text strong {
        margin-bottom: 1.15em;
        color: var(--foreground);
        font-weight: 500;
    }

    .bio-panel__side-text p:last-child { color: var(--muted); }

    .team-layout {
        grid-column: 1 / -1;
        grid-row: 4;
        margin-top: clamp(120px, 16vh, 220px);
    }
}

/* Keep the identity sentence on one line whenever the viewport can support it. */
@media (max-width: 1300px) and (min-width: 1001px) {
    .bio-panel__foundation .bio-statement__new {
        font-size: clamp(27px, 2.15vw, 36px);
    }
}

@media (max-width: 1000px) {
    .bio-panel__foundation .bio-statement__new {
        width: auto;
        white-space: normal;
    }
}

/* BIO entrance — left composition first, then the right column. */
.bio-panel__text--manifest,
.bio-panel__copy-pair p,
.bio-panel__foundation .bio-statement__old,
.bio-panel__foundation .bio-statement__new,
.bio-panel__team-copy,
.bio-panel__side-block {
    opacity: 0;
    transform: translateY(24px);
    will-change: opacity, transform;
}

/* LEFT SIDE — top to bottom. */
.bio-panel.is-open .bio-panel__text--manifest {
    animation: bioContentIn 980ms 140ms cubic-bezier(.16,1,.3,1) both;
}

.bio-panel.is-open .bio-panel__foundation .bio-statement__old {
    animation: bioContentIn 900ms 560ms cubic-bezier(.16,1,.3,1) both;
}

/* The strike starts only after the sentence has settled and draws deliberately. */
.bio-panel.is-open .bio-panel__foundation .bio-statement__old::after {
    animation: bioStrike 1500ms 980ms cubic-bezier(.16,1,.3,1) forwards;
}

.bio-panel.is-open .bio-panel__foundation .bio-statement__new {
    animation: bioContentIn 940ms 1320ms cubic-bezier(.16,1,.3,1) both;
}

.bio-panel.is-open .bio-panel__team-copy {
    animation: bioContentIn 920ms 1760ms cubic-bezier(.16,1,.3,1) both;
}

/* RIGHT SIDE — starts after the left-hand narrative is established. */
.bio-panel.is-open .bio-panel__copy-pair p:first-child {
    animation: bioContentIn 940ms 2180ms cubic-bezier(.16,1,.3,1) both;
}

.bio-panel.is-open .bio-panel__copy-pair p:last-child {
    animation: bioContentIn 940ms 2520ms cubic-bezier(.16,1,.3,1) both;
}

.bio-panel.is-open .bio-panel__side-block {
    animation: bioContentIn 920ms 2880ms cubic-bezier(.16,1,.3,1) both;
}

@keyframes bioContentIn {
    0% { opacity: 0; transform: translateY(24px); }
    35% { opacity: .32; }
    100% { opacity: 1; transform: translateY(0); }
}

@media (prefers-reduced-motion: reduce) {
    .bio-panel__text--manifest,
    .bio-panel__copy-pair p,
    .bio-panel__foundation .bio-statement__old,
    .bio-panel__foundation .bio-statement__new,
    .bio-panel__team-copy,
    .bio-panel__side-block {
        opacity: 1 !important;
        transform: none !important;
        animation: none !important;
    }
    .bio-panel__foundation .bio-statement__old::after {
        transform: scaleX(1) !important;
        animation: none !important;
    }
}
</style>


<style id="inflect-bio-explicit-breaks-v5">
/* Exact line breaks requested for the BIO composition. */
.bio-panel__text--manifest br {
    display: block;
}

.bio-panel__side-text--fixed-lines p {
    margin: 0;
    line-height: 1.35;
}

.bio-panel__side-text--fixed-lines strong,
.bio-panel__side-text--fixed-lines span {
    display: block;
    margin: 0;
    line-height: inherit;
}

.bio-panel__side-text--fixed-lines strong {
    color: var(--foreground);
    font-weight: 500;
}

.bio-panel__side-text--fixed-lines span {
    color: var(--muted);
}

@media (max-width: 1000px) {
    .bio-panel__text--manifest br {
        display: none;
    }

    .bio-panel__side-text--fixed-lines span {
        display: inline;
    }

    .bio-panel__side-text--fixed-lines span + span::before {
        content: " ";
    }
}
</style>


<style id="inflect-bio-clean-motion-v5">
/* BIO motion: one calm reading path, without competing movements. */
.bio-panel__text--manifest,
.bio-panel__foundation .bio-statement__old,
.bio-panel__foundation .bio-statement__new,
.bio-panel__team-copy,
.bio-panel__copy-pair p,
.bio-panel__side-block {
    opacity: 0;
    transform: translate3d(0, 12px, 0);
    filter: blur(2px);
    will-change: opacity, transform, filter;
}

.bio-panel.is-open .bio-panel__text--manifest,
.bio-panel.is-open .bio-panel__foundation .bio-statement__old,
.bio-panel.is-open .bio-panel__foundation .bio-statement__new,
.bio-panel.is-open .bio-panel__team-copy,
.bio-panel.is-open .bio-panel__copy-pair p,
.bio-panel.is-open .bio-panel__side-block {
    animation-name: bioCleanReveal;
    animation-duration: 760ms;
    animation-timing-function: cubic-bezier(.22, 1, .36, 1);
    animation-fill-mode: both;
}

/* Left column reads as one uninterrupted vertical sequence. */
.bio-panel.is-open .bio-panel__text--manifest { animation-delay: 180ms; }
.bio-panel.is-open .bio-panel__foundation .bio-statement__old { animation-delay: 460ms; }
.bio-panel.is-open .bio-panel__foundation .bio-statement__new { animation-delay: 1040ms; }
.bio-panel.is-open .bio-panel__team-copy { animation-delay: 1280ms; }

/* Right column enters only once the left-hand thought is understood. */
.bio-panel.is-open .bio-panel__copy-pair p:first-child { animation-delay: 1640ms; }
.bio-panel.is-open .bio-panel__copy-pair p:last-child { animation-delay: 1880ms; }
.bio-panel.is-open .bio-panel__side-block { animation-delay: 2160ms; }

/* A deliberate, continuous strike—not a quick UI effect. */
.bio-panel.is-open .bio-panel__foundation .bio-statement__old::after {
    animation: bioCleanStrike 1280ms 690ms cubic-bezier(.65, 0, .35, 1) forwards;
}

@keyframes bioCleanReveal {
    0% {
        opacity: 0;
        transform: translate3d(0, 12px, 0);
        filter: blur(2px);
    }
    100% {
        opacity: 1;
        transform: translate3d(0, 0, 0);
        filter: blur(0);
    }
}

@keyframes bioCleanStrike {
    from { transform: scaleX(0); }
    to { transform: scaleX(1); }
}

/* Hover imagery remains dormant until the complete pillar introduction is visible. */
body:not(.hero-pillars-ready) .hero-hover-stage {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

@media (prefers-reduced-motion: reduce) {
    .bio-panel__text--manifest,
    .bio-panel__foundation .bio-statement__old,
    .bio-panel__foundation .bio-statement__new,
    .bio-panel__team-copy,
    .bio-panel__copy-pair p,
    .bio-panel__side-block {
        opacity: 1;
        transform: none;
        filter: none;
    }
}
</style>


<style id="inflect-bio-motion-final-v6">
/* =========================================================
   BIO — CLEAN, EDITORIAL ENTRANCE
   Left composition arrives as one complete thought.
   Right-hand copy follows in a calm reading sequence.
========================================================= */

/* Reset every earlier BIO entrance rule. */
.bio-panel__text--manifest,
.bio-panel__foundation .bio-statement__old,
.bio-panel__foundation .bio-statement__new,
.bio-panel__team-copy,
.bio-panel__copy-pair p,
.bio-panel__side-block {
    animation: none !important;
    filter: none !important;
    will-change: opacity, transform;
}

/* LEFT: the complete composition appears together. */
.bio-panel__text--manifest,
.bio-panel__foundation .bio-statement__old,
.bio-panel__foundation .bio-statement__new,
.bio-panel__team-copy {
    opacity: 0;
    transform: translate3d(0, 16px, 0);
    transition:
        opacity 920ms cubic-bezier(.22, 1, .36, 1),
        transform 1080ms cubic-bezier(.22, 1, .36, 1);
}

.bio-panel.is-open .bio-panel__text--manifest,
.bio-panel.is-open .bio-panel__foundation .bio-statement__old,
.bio-panel.is-open .bio-panel__foundation .bio-statement__new,
.bio-panel.is-open .bio-panel__team-copy {
    opacity: 1;
    transform: translate3d(0, 0, 0);
    transition-delay: 170ms;
}

/* The strike begins after the left composition has settled.
   It remains the only pronounced gesture in the sequence. */
.bio-panel__foundation .bio-statement__old::after {
    animation: none !important;
    transform: scaleX(0);
    transform-origin: left center;
    transition: transform 1450ms cubic-bezier(.65, 0, .35, 1);
}

.bio-panel.is-open .bio-panel__foundation .bio-statement__old::after {
    transform: scaleX(1);
    transition-delay: 820ms;
}

/* RIGHT: one calm reading path, opacity-led with almost no travel. */
.bio-panel__copy-pair p,
.bio-panel__side-block {
    opacity: 0;
    transform: translate3d(0, 8px, 0);
    transition:
        opacity 980ms cubic-bezier(.22, 1, .36, 1),
        transform 1100ms cubic-bezier(.22, 1, .36, 1);
}

.bio-panel.is-open .bio-panel__copy-pair p:first-child {
    opacity: 1;
    transform: translate3d(0, 0, 0);
    transition-delay: 1180ms;
}

.bio-panel.is-open .bio-panel__copy-pair p:last-child {
    opacity: 1;
    transform: translate3d(0, 0, 0);
    transition-delay: 1490ms;
}

.bio-panel.is-open .bio-panel__side-block {
    opacity: 1;
    transform: translate3d(0, 0, 0);
    transition-delay: 1810ms;
}

/* Hero imagery stays inactive until the entire pillar intro has completed. */
body:not(.hero-pillars-ready) .hero-hover-stage,
body:not(.hero-pillars-ready) .hero-hover-image {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

@media (prefers-reduced-motion: reduce) {
    .bio-panel__text--manifest,
    .bio-panel__foundation .bio-statement__old,
    .bio-panel__foundation .bio-statement__new,
    .bio-panel__team-copy,
    .bio-panel__copy-pair p,
    .bio-panel__side-block {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
    }

    .bio-panel__foundation .bio-statement__old::after {
        transform: scaleX(1) !important;
        transition: none !important;
    }
}
</style>


<style id="inflect-final-mobile-fixes-v7">
/* Final fixes applied to index3.html. */

/* Preserve the intentional three-line manifesto on mobile.
   Earlier CSS hid <br>, which collapsed "charakter" and "i" into "charakteri". */
@media (max-width: 1000px) {
    .bio-panel__text--manifest br {
        display: block !important;
    }
}

/* Keep the animated strike stable on narrow screens.
   The old sentence stays on one line and scales just enough to fit the viewport,
   so the pseudo-element always draws one clean continuous line. */
@media (max-width: 720px) {
    .bio-panel__foundation .bio-statement {
        max-width: 100%;
    }

    .bio-panel__foundation .bio-statement__old {
        display: inline-block !important;
        width: max-content;
        max-width: 100%;
        white-space: nowrap;
        font-size: clamp(21px, 6.25vw, 27px);
        line-height: 1.08;
        letter-spacing: -.045em;
    }

    .bio-panel__foundation .bio-statement__old::after {
        left: 0;
        right: auto;
        top: 52%;
        width: 100%;
        height: 0.07em;
    }
}

@media (max-width: 380px) {
    .bio-panel__foundation .bio-statement__old {
        font-size: clamp(19px, 5.9vw, 22px);
    }
}
</style>


<style id="inflect-team-grid-final">
/* Team: 3 columns on desktop, 2 columns on mobile. */
.team-layout {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    row-gap: clamp(44px, 5vw, 76px);
}

@media (max-width: 720px) {
    .team-layout {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        column-gap: 10px;
        row-gap: 34px;
    }

    .team-member h3 {
        font-size: clamp(17px, 5vw, 21px);
    }

    .team-member p {
        max-width: none;
        font-size: clamp(10px, 3vw, 12px);
        line-height: 1.3;
    }
}
</style>


<style id="inflect-contact-form-refinement">
/* Budget options — compact rectangular buttons */
.contact-form__budget-label {
    min-height: 36px;
    padding: 7px 10px;
    border: 1px solid rgba(255,255,255,.42);
    border-radius: 0;
    background: transparent;
    color: var(--muted);
    white-space: nowrap;
    transition:
        background-color 180ms ease,
        border-color 180ms ease,
        color 180ms ease;
}

.contact-form__budget-input:checked + .contact-form__budget-label {
    border-color: var(--foreground);
    background: var(--foreground);
    color: var(--background);
}

.contact-form__budget-input:focus-visible + .contact-form__budget-label {
    outline: 1px solid var(--foreground);
    outline-offset: 3px;
}

@media (hover: hover) and (pointer: fine) {
    .contact-form__budget-label:hover {
        border-color: var(--foreground);
        color: var(--foreground);
    }

    .contact-form__budget-input:checked + .contact-form__budget-label:hover {
        color: var(--background);
    }
}

@media (max-width: 720px) {
    .contact-form__budgets {
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 4px;
    }

    .contact-form__budget-label {
        min-height: 34px;
        padding: 6px 3px;
        font-size: clamp(7px, 2.15vw, 10px);
        letter-spacing: -0.02em;
        white-space: nowrap;
    }
}

/* Custom consent checkbox */
.contact-form__consent input {
    appearance: none;
    -webkit-appearance: none;
    width: 14px;
    height: 14px;
    margin: 0;
    border: 1px solid rgba(255,255,255,.62);
    border-radius: 0;
    background: transparent;
    cursor: pointer;
    transition: background-color 160ms ease, border-color 160ms ease;
}

.contact-form__consent input:checked {
    border-color: var(--foreground);
    background: var(--foreground);
    box-shadow: inset 0 0 0 3px var(--background);
}

.contact-form__consent input:focus-visible {
    outline: 1px solid var(--foreground);
    outline-offset: 3px;
}
</style>


<style id="inflect-projects-cms-motion">
/* Dynamic projects gallery: two-column layout, reveal, stronger parallax and mouse depth */
.topbar__projects{font-size:10px!important;letter-spacing:.08em!important;text-transform:none!important}
.projects-panel__canvas{position:relative;min-height:100svh;padding-top:calc(var(--header-height) + 88px);padding-bottom:clamp(120px,14vw,240px)}
.project-media{position:absolute;left:var(--x,5%);top:var(--y,120px);width:var(--w,42%);margin:0;opacity:0;transform:translate3d(var(--mouse-x,0px),calc(var(--reveal-y,54px) + var(--parallax-y,0px) + var(--mouse-y,0px)),0) scale(.975);transition:opacity 820ms cubic-bezier(.22,1,.36,1),transform 980ms cubic-bezier(.22,1,.36,1);will-change:transform,opacity;z-index:1}
.project-media.is-visible{opacity:1;--reveal-y:0px;transform:translate3d(var(--mouse-x,0px),calc(var(--reveal-y,0px) + var(--parallax-y,0px) + var(--mouse-y,0px)),0) scale(1)}
.project-media img,.project-media video{display:block;width:100%;height:auto;object-fit:contain;pointer-events:none;user-select:none}.project-media video{background:#111}
.projects-panel__footer{min-height:100svh;display:flex;flex-direction:column;justify-content:center;padding-top:var(--header-height);padding-bottom:clamp(44px,6vw,80px)}
.projects-panel__footer-pillars{margin:auto 0}.projects-panel__cta{margin-top:auto}
@media(max-width:720px){.topbar__projects{font-size:9px!important}.projects-panel__canvas{padding-top:calc(var(--header-height) + 48px)}.project-media{width:var(--w,44%);left:var(--x,4%)}.projects-panel__footer{min-height:100svh;padding-top:var(--header-height)}}
@media(prefers-reduced-motion:reduce){.project-media{transition:none!important;transform:none!important}.project-media.is-visible{opacity:1}}
</style>


<style id="inflect-projects-final-corrections">
/* Final corrections: navigation label, video scaling and footer hero parity */
.topbar__projects {
    font-size: 13px !important;
    line-height: 1 !important;
    letter-spacing: .14em !important;
    text-transform: uppercase !important;
}

.project-media--video {
    overflow: hidden;
}

.project-media--video video {
    display: block;
    width: 100% !important;
    max-width: 100%;
    height: auto !important;
    max-height: min(78svh, 920px);
    margin-inline: auto;
    object-fit: contain;
}

@media (min-width: 721px) {
    .projects-panel__footer-pillars {
        display: grid;
        grid-template-columns: repeat(3, max-content);
        justify-content: center;
        align-items: center;
        column-gap: clamp(44px, 4.6vw, 104px);
        width: auto;
        max-width: calc(100vw - (var(--page-gutter) * 2));
        margin: auto auto clamp(96px, 12vw, 190px);
        font-size: initial;
        line-height: initial;
        letter-spacing: initial;
    }

    .footer-pillar {
        width: max-content;
        height: 1.18em;
        padding-inline: .04em;
        font-size: var(--type-display-large);
        font-weight: 600;
        line-height: 1.08;
        letter-spacing: -.065em;
    }

    .footer-pillar__sizer,
    .footer-pillar__text {
        height: 1.18em;
        line-height: 1.08;
    }

    .footer-pillar__text {
        padding-bottom: .08em;
    }
}

@media (max-width: 720px) {
    .topbar__projects {
        font-size: 11px !important;
        letter-spacing: .12em !important;
    }

    .project-media--video video {
        max-height: 64svh;
    }
}
</style>


<style id="inflect-projects-gallery-v2">
/* Projects gallery only — calm editorial collage with scroll/touch depth */
.projects-panel__canvas {
    position: relative;
    min-height: 100svh;
    padding-top: calc(var(--header-height) + clamp(72px, 8vw, 132px));
    padding-bottom: clamp(150px, 18vw, 300px);
    overflow: hidden;
}

.project-media {
    position: absolute;
    left: var(--x, 5%);
    top: var(--y, 120px);
    width: var(--w, 40%);
    margin: 0;
    opacity: 0;
    transform-origin: 50% 50%;
    transform: translate3d(
        calc(var(--drift-x, 0px) + var(--gesture-x, 0px)),
        calc(var(--reveal-y, 46px) + var(--parallax-y, 0px) + var(--gesture-y, 0px)),
        0
    ) rotate(var(--tilt, 0deg)) scale(var(--scale, .975));
    transition:
        opacity 760ms cubic-bezier(.22,1,.36,1),
        transform 900ms cubic-bezier(.22,1,.36,1);
    will-change: transform, opacity;
    z-index: var(--z, 1);
}

.project-media.is-visible {
    opacity: 1;
    --reveal-y: 0px;
    --scale: 1;
}

.project-media img,
.project-media video {
    display: block;
    width: 100%;
    height: auto;
    max-width: 100%;
    object-fit: contain;
    pointer-events: none;
    user-select: none;
}

.project-media--video { overflow: visible; }
.project-media--video video {
    width: 100% !important;
    height: auto !important;
    max-height: min(74svh, 860px);
    object-fit: contain;
    background: #111;
}

@media (hover: hover) and (pointer: fine) {
    .project-media { transition-duration: 760ms, 700ms; }
}

@media (max-width: 720px) {
    .projects-panel__canvas {
        padding-top: calc(var(--header-height) + 52px);
        padding-bottom: 150px;
    }

    .project-media--video video { max-height: 68svh; }
}

@media (prefers-reduced-motion: reduce) {
    .project-media,
    .project-media.is-visible {
        opacity: 1;
        transition: none !important;
        transform: none !important;
    }
}
</style>


<style id="inflect-service-flow-v2">
.service-panel{
  --sf-bg:#111111;
  --sf-fg:#ffffff;
  --sf-muted:rgba(255,255,255,.62);
  background-color:var(--sf-bg);
  color:var(--sf-fg);
  transition:background-color 360ms cubic-bezier(.22,1,.36,1),color 360ms cubic-bezier(.22,1,.36,1),opacity 420ms ease,transform 700ms cubic-bezier(.22,1,.36,1);
}
.service-panel.is-inverted{
  --sf-bg:#f2f0ea;
  --sf-fg:#111111;
  --sf-muted:rgba(17,17,17,.62);
}
.service-panel .service-panel__eyebrow,
.service-panel .service-panel__lead,
.service-panel .service-step__number,
.service-panel .service-step__tagline,
.service-panel .service-step__description{
  color:var(--sf-muted);
  transition:color 360ms cubic-bezier(.22,1,.36,1);
}
.service-panel .service-panel__title,
.service-panel .service-step__title,
.service-panel .service-panel__cta{
  color:var(--sf-fg);
  transition:color 360ms cubic-bezier(.22,1,.36,1);
}
.service-panel .service-step{
  border-color:color-mix(in srgb,var(--sf-fg) 20%,transparent);
  transition:opacity 480ms ease,transform 650ms cubic-bezier(.22,1,.36,1),background-color 260ms ease,color 260ms ease,border-color 260ms ease;
}
.service-panel .service-step:last-child{border-bottom-color:color-mix(in srgb,var(--sf-fg) 20%,transparent);}
@media (hover:hover) and (pointer:fine){
  .service-panel .service-step:hover{
    background:var(--sf-fg);
    color:var(--sf-bg);
    border-color:var(--sf-fg);
  }
  .service-panel .service-step:hover .service-step__title{color:var(--sf-bg);}
  .service-panel .service-step:hover .service-step__number,
  .service-panel .service-step:hover .service-step__tagline,
  .service-panel .service-step:hover .service-step__description{
    color:color-mix(in srgb,var(--sf-bg) 68%,transparent);
  }
}
.service-panel__section,
.service-continuation{
  position:relative;
  min-height:100svh;
}
.service-panel__section + .service-continuation,
.service-continuation + .service-continuation{
  border-top:0!important;
}
@media (min-width:821px){
  .service-panel__section>.service-panel__intro,
  .service-continuation__header{
    position:sticky!important;
    top:calc(var(--header-height) + var(--space-6))!important;
    align-self:start;
  }
}
.service-end-cta{
  grid-column:1/-1;
  min-height:72svh;
  display:flex;
  flex-direction:column;
  justify-content:flex-end;
  align-items:flex-start;
  padding:clamp(90px,12vh,150px) 0 0;
  margin-top:clamp(80px,10vh,130px);
}
.service-end-cta__eyebrow{
  margin-bottom:18px;
  color:var(--sf-muted);
  font-size:13px;
  letter-spacing:.16em;
  text-transform:uppercase;
}
.service-end-cta__title{
  max-width:1100px;
  font-size:clamp(48px,6.8vw,110px);
  font-weight:600;
  line-height:.92;
  letter-spacing:-.065em;
}
.service-end-cta__button{
  margin-top:clamp(36px,5vh,64px);
  border:0;
  padding:0;
  background:transparent;
  color:var(--sf-fg);
  cursor:pointer;
  font-size:clamp(24px,2.4vw,42px);
  font-weight:500;
  letter-spacing:-.04em;
  transition:color 360ms cubic-bezier(.22,1,.36,1),transform 320ms cubic-bezier(.22,1,.36,1);
}
.service-end-cta__button:hover{transform:translateX(8px);}
@media(max-width:820px){
  .service-end-cta{min-height:55svh;padding-top:72px;margin-top:72px;}
  .service-end-cta__title{font-size:clamp(46px,13vw,72px);}
}
</style>

<style id="inflect-service-cta-shared">
.service-panel__end-cta{grid-column:1/-1;width:100%;margin-top:clamp(90px,12vw,180px);padding-bottom:20px}
.service-panel__end-cta .panel-end-cta__button{color:var(--sf-fg);border-top-color:color-mix(in srgb,var(--sf-fg) 24%,transparent);transition:color 360ms cubic-bezier(.22,1,.36,1),border-color 360ms cubic-bezier(.22,1,.36,1)}
.service-panel__end-cta .panel-end-cta__eyebrow{color:var(--sf-muted);transition:color 360ms cubic-bezier(.22,1,.36,1)}
.nav-arrow{font-family:inherit!important;font-style:normal;font-weight:inherit;text-rendering:auto}
</style>
<style id="inflect-areas-nav">
.topbar__areas{border:0;background:transparent;cursor:pointer;font-size:var(--type-label);font-weight:500;line-height:1;letter-spacing:var(--tracking-label);text-transform:uppercase;pointer-events:auto}
.topbar__areas-label{display:inline-block;min-width:0;text-align:right}
</style>
<style id="inflect-services-polish-v3">
/* Keep only the font glyph arrow. */
.nav-arrow::before,
.nav-arrow::after{content:none!important;display:none!important}
.nav-arrow{
  position:static!important;
  width:auto!important;
  height:auto!important;
  transform:none;
  vertical-align:baseline;
}

/* Service pillar title rotates between brand pillar and service name. */
.service-panel__title{
  overflow:hidden;
}
.service-title-switch{
  position:relative;
  display:block;
  height:.94em;
  overflow:hidden;
}
.service-title-switch__track{
  display:flex;
  flex-direction:column;
  height:1.88em;
  transform:translateY(0);
  animation:serviceTitleCycle 6s cubic-bezier(.22,1,.36,1) infinite;
  will-change:transform;
}
.service-title-switch__text{
  display:flex;
  align-items:center;
  height:.94em;
  white-space:nowrap;
}
@keyframes serviceTitleCycle{
  0%,38%{transform:translateY(0)}
  46%,88%{transform:translateY(-.94em)}
  96%,100%{transform:translateY(0)}
}

/* Faster theme response - no loading-like lag. */
.service-panel{
  transition:background-color 220ms cubic-bezier(.22,1,.36,1),color 220ms cubic-bezier(.22,1,.36,1),opacity 420ms ease,transform 700ms cubic-bezier(.22,1,.36,1)!important;
}
.service-panel .service-panel__eyebrow,
.service-panel .service-panel__lead,
.service-panel .service-step__number,
.service-panel .service-step__tagline,
.service-panel .service-step__description,
.service-panel .service-panel__title,
.service-panel .panel-end-cta__button,
.service-panel .panel-end-cta__eyebrow{
  transition-duration:220ms!important;
}

/* All pillar headings use exactly the same scale on mobile. */
@media(max-width:820px){
  #service-title,
  .service-continuation__header .service-panel__title{
    font-size:clamp(52px,16vw,82px)!important;
    line-height:.9!important;
    letter-spacing:-.065em!important;
  }
  .service-title-switch,
  .service-title-switch__text{
    height:.94em;
  }
}
@media(prefers-reduced-motion:reduce){
  .service-title-switch__track{animation:none!important}
}
</style>
</head>

<body>

<div class="site-intro" aria-hidden="true">
    <img class="site-intro__logo" src="assets/inflect-logo-white.svg" alt="">
</div>

<header class="topbar">
        <a class="topbar__studio" href="#" aria-label="Inflect Studio — strona główna">
            <img src="assets/inflect-logo-white.svg" alt="Inflect Studio">
        </a>

        <nav class="topbar__nav" aria-label="Główna nawigacja">
            <button class="topbar__bio" type="button" aria-expanded="false" aria-controls="bio-panel">
                <span class="topbar__bio-label">[ B I O ]</span>
            </button>
            <button class="topbar__areas" type="button" aria-expanded="false" aria-controls="service-panel">
                <span class="topbar__areas-label">[ O B S Z A R Y ]</span>
            </button>
            <button class="topbar__projects" type="button" aria-expanded="false" aria-controls="projects-panel">
                <span class="topbar__projects-label">[ P R O J E K T Y ]</span>
            </button>
            <button class="topbar__contact" type="button" aria-expanded="false" aria-controls="contact-panel">
                <span class="topbar__contact-label">[ K O N T A K T ]</span>
            </button>
        </nav>
    </header>

    <section
        class="bio-panel"
        id="bio-panel"
        aria-hidden="true"
    >

        
<div class="bio-panel__grid">

            <div class="bio-panel__main">
                <div class="bio-panel__text bio-panel__text--manifest">
                    <p>Wyznaczamy kierunek,<br>kształtujemy charakter<br>i wzmacniamy obecność.</p>
                </div>

                <div class="bio-panel__copy-pair">
                    <p>Wspieramy firmy na różnych etapach rozwoju, od budowania nowych marek po rozwój tych, które mają odwagę wejść na wyższy poziom.</p>
                    <p>Nie wierzymy w przypadkowe decyzje. Wierzymy, że biznes zasługuje na rozwiązania, które pracują.</p>
                </div>

                <div class="bio-panel__foundation">
                    <p class="bio-statement">
                        <span class="bio-statement__old">Nie jesteśmy kolejną agencją.</span>
                        <span class="bio-statement__new">Jesteśmy studiem projektowym z Krakowa.</span>
                    </p>
                    <p class="bio-panel__team-copy">Tworzymy interdyscyplinarny zespół wokół potrzeb projektu, dobierając kompetencje do konkretnych wyzwań.</p>
                </div>
            </div>

            <aside class="bio-panel__side">
                <div class="bio-panel__side-block">
                    <div class="bio-panel__side-text bio-panel__side-text--fixed-lines">
                        <p>
                            <strong>Nie pracujemy z każdym.</strong>
                            <span>Najlepiej odnajdujemy się tam,</span>
                            <span>gdzie ambicja jest większa od kompromisów.</span>
                        </p>
                    </div>
                </div>
            </aside>

            <div class="team-layout" aria-label="Zespół Inflect Studio">
                <article class="team-member">
                    <img src="assets/team/mateusz.jpg" alt="Mateusz" loading="lazy" decoding="async">
                    <h3>Mateusz</h3>
                    <p>Founder &amp; Creative Director</p>
                </article>

                <article class="team-member">
                    <img src="assets/team/klaudia.jpg" alt="Klaudia" loading="lazy" decoding="async">
                    <h3>Klaudia</h3>
                    <p>Operations Director</p>
                </article>

                <article class="team-member">
                    <img src="assets/team/pawel.jpg" alt="Paweł" loading="lazy" decoding="async">
                    <h3>Paweł</h3>
                    <p>Head of Production</p>
                </article>

                <article class="team-member">
                    <img src="assets/team/filip.jpg" alt="Filip" loading="lazy" decoding="async">
                    <h3>Filip</h3>
                    <p>Multidisciplinary Creative</p>
                </article>

                <article class="team-member">
                    <img src="assets/team/lukasz.jpg" alt="Łukasz" loading="lazy" decoding="async">
                    <h3>Łukasz</h3>
                    <p>Head of Technology</p>
                </article>

                <article class="team-member">
                    <img src="assets/team/soja.jpg" alt="Soja" loading="lazy" decoding="async">
                    <h3>Soja</h3>
                    <p>Head of Research</p>
                </article>
            </div>

        </div>

        <div class="panel-end-cta bio-panel__end-cta">
            <button class="panel-end-cta__button js-open-contact" type="button">
                <span class="panel-end-cta__eyebrow">Masz projekt?</span>
                <span class="panel-end-cta__title">Porozmawiajmy <span class="nav-arrow" aria-hidden="true">↗</span></span>
            </button>
        </div>
</section>


    <section class="projects-panel" id="projects-panel" aria-hidden="true">
        <div class="projects-panel__canvas" id="projects-canvas">
<?php foreach ($projects as $index => $project):
    $file = isset($project['file']) ? basename((string) $project['file']) : '';
    if ($file === '') continue;
?>
<?php $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION)); ?>
    <figure class="project-media<?= $extension === 'mp4' ? ' project-media--video' : '' ?>" data-project-index="<?= (int) $index ?>">
<?php if ($extension === 'mp4'): ?>
        <video data-src="assets/projects/<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>" muted loop playsinline preload="none" aria-label="Materiał wideo z realizacji"></video>
<?php else: ?>
        <img src="assets/projects/<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy" decoding="async">
<?php endif; ?>
    </figure>
<?php endforeach; ?>
</div>

        <div class="projects-panel__footer">
            
<div class="projects-panel__footer-pillars" aria-label="Obszary działalności Inflect Studio">
    <button class="footer-pillar" type="button" data-service="direction" aria-label="Kierunek — Strategia">
        <span class="footer-pillar__sizer">Strategia</span>
        <span class="footer-pillar__track" aria-hidden="true">
            <span class="footer-pillar__text">Kierunek</span>
            <span class="footer-pillar__text">Strategia</span>
        </span>
    </button>

    <button class="footer-pillar" type="button" data-service="character" aria-label="Charakter — Design">
        <span class="footer-pillar__sizer">Charakter</span>
        <span class="footer-pillar__track" aria-hidden="true">
            <span class="footer-pillar__text">Charakter</span>
            <span class="footer-pillar__text">Design</span>
        </span>
    </button>

    <button class="footer-pillar" type="button" data-service="presence" aria-label="Obecność — Social Media">
        <span class="footer-pillar__sizer">Social Media</span>
        <span class="footer-pillar__track" aria-hidden="true">
            <span class="footer-pillar__text">Obecność</span>
            <span class="footer-pillar__text">Social Media</span>
        </span>
    </button>
</div>


            <button class="panel-end-cta__button projects-panel__cta js-open-contact" type="button">
                <span class="panel-end-cta__eyebrow">Masz projekt?</span>
                <span class="panel-end-cta__title">Porozmawiajmy <span class="nav-arrow" aria-hidden="true">↗</span></span>
            </button>
        </div>
    </section>

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

    <section
        class="service-panel"
        id="service-panel"
        aria-hidden="true"
    >
        <div class="service-panel__inner">
            <div class="service-panel__intro">
                <div class="service-panel__eyebrow" id="service-eyebrow">
                    Kierunek → Strategia
                </div>

                <h2 class="service-panel__title" id="service-title">
                    Kierunek
                </h2>

                <p class="service-panel__lead" id="service-lead"></p>

                <button class="service-panel__cta service-panel__cta--desktop" type="button">
                    <span>Masz projekt?</span>
                    <strong>Porozmawiajmy <span class="nav-arrow" aria-hidden="true">↗</span></strong>
                </button>
            </div>

            <div
                class="service-panel__list"
                id="service-list"
                aria-live="polite"
            ></div>

            <button class="service-panel__cta service-panel__cta--mobile" type="button">
                <span>Masz projekt?</span>
                <strong>Porozmawiajmy <span class="nav-arrow" aria-hidden="true">↗</span></strong>
            </button>
        </div>
    </section>

    <main class="hero">

        <section class="hero__content">

            <div
                class="pillars"
                aria-label="Obszary działalności Inflect Studio"
            >

                <button
                    class="pillar"
                    type="button"
                    data-service="direction"
                    aria-label="Kierunek — Strategia"
                >
                    <span class="pillar__sizer">Strategia</span>

                    <span
                        class="pillar__track"
                        aria-hidden="true"
                    >
                        <span class="pillar__text">Kierunek</span>
                        <span class="pillar__text">Strategia</span>
                    </span>
                </button>

                <span
                    class="separator"
                    aria-hidden="true"
                ></span>

                <button
                    class="pillar"
                    type="button"
                    data-service="character"
                    aria-label="Charakter — Design"
                >
                    <span class="pillar__sizer">Charakter</span>

                    <span
                        class="pillar__track"
                        aria-hidden="true"
                    >
                        <span class="pillar__text">Charakter</span>
                        <span class="pillar__text">Design</span>
                    </span>
                </button>

                <span
                    class="separator"
                    aria-hidden="true"
                ></span>

                <button
                    class="pillar"
                    type="button"
                    data-service="presence"
                    aria-label="Obecność — Social Media"
                >
                    <span class="pillar__sizer">Social Media</span>

                    <span
                        class="pillar__track"
                        aria-hidden="true"
                    >
                        <span class="pillar__text">Obecność</span>
                        <span class="pillar__text">Social Media</span>
                    </span>
                </button>

            </div>

        </section>


        <section
            class="logos"
            aria-label="Wybrani klienci"
        >

            <div class="logos__viewport">

                <div class="logos__track">

                    <div class="logos__group">

                  <div class="logo">
    <img src="assets/clients/client-yamato.png" alt="Yamato">
</div>

<div class="logo">
    <img src="assets/clients/client-ferrero.png" alt="Ferrero">
</div>

<div class="logo">
    <img src="assets/clients/client-hermetic.png" alt="Hermetic">
</div>

<div class="logo">
    <img src="assets/clients/client-eurotax.png" alt="Eurotax">
</div>

<div class="logo">
    <img src="assets/clients/client-iqos.png" alt="IQOS">
</div>

<div class="logo">
    <img src="assets/clients/client-oknoplast.png" alt="Oknoplast">
</div>

<div class="logo">
    <img src="assets/clients/client-wersow.png" alt="Wersow">
</div>

<div class="logo">
    <img src="assets/clients/client-gms.png" alt="GMS">
</div>

<div class="logo">
    <img src="assets/clients/client-hammer.png" alt="Hammer">
</div>

<div class="logo">
    <img src="assets/clients/client-royalspace.png" alt="Royal Space">
</div>

<div class="logo">
    <img src="assets/clients/client-platynov.png" alt="Platynov">
</div>

<div class="logo">
    <img src="assets/clients/client-streetpark.png" alt="Streetpark">
</div>

<div class="logo">
    <img src="assets/clients/client-diag.png" alt="Diag">
</div>

                    </div>

                    <div
                        class="logos__group"
                        aria-hidden="true"
                    >

                  <div class="logo">
    <img src="assets/clients/client-yamato.png" alt="Yamato">
</div>

<div class="logo">
    <img src="assets/clients/client-ferrero.png" alt="Ferrero">
</div>

<div class="logo">
    <img src="assets/clients/client-hermetic.png" alt="Hermetic">
</div>

<div class="logo">
    <img src="assets/clients/client-eurotax.png" alt="Eurotax">
</div>

<div class="logo">
    <img src="assets/clients/client-iqos.png" alt="IQOS">
</div>

<div class="logo">
    <img src="assets/clients/client-oknoplast.png" alt="Oknoplast">
</div>

<div class="logo">
    <img src="assets/clients/client-wersow.png" alt="Wersow">
</div>

<div class="logo">
    <img src="assets/clients/client-gms.png" alt="GMS">
</div>

<div class="logo">
    <img src="assets/clients/client-hammer.png" alt="Hammer">
</div>

<div class="logo">
    <img src="assets/clients/client-royalspace.png" alt="Royal Space">
</div>

<div class="logo">
    <img src="assets/clients/client-platynov.png" alt="Platynov">
</div>

<div class="logo">
    <img src="assets/clients/client-streetpark.png" alt="Streetpark">
</div>

<div class="logo">
    <img src="assets/clients/client-diag.png" alt="Diag">
</div>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <script>
        const pillars = document.querySelectorAll(".pillar");
        const footerPillars = document.querySelectorAll(".footer-pillar");
        const siteIntro = document.querySelector(".site-intro");
        const introLogo = document.querySelector(".site-intro__logo");
        const homeLogo = document.querySelector(".topbar__studio");
        const serviceCtas = document.querySelectorAll(".service-panel__cta");

        const bioButton = document.querySelector(".topbar__bio");
        const bioButtonLabel = document.querySelector(".topbar__bio-label");
        const bioPanel = document.querySelector(".bio-panel");

        const areasButton = document.querySelector(".topbar__areas");
        const areasButtonLabel = document.querySelector(".topbar__areas-label");

        const projectsButton = document.querySelector(".topbar__projects");
        const projectsButtonLabel = document.querySelector(".topbar__projects-label");
        const projectsPanel = document.querySelector(".projects-panel");

        const contactButton = document.querySelector(".topbar__contact");
        const contactButtonLabel = document.querySelector(".topbar__contact-label");
        const contactPanel = document.querySelector(".contact-panel");

        const servicePanel = document.querySelector("#service-panel");
        const serviceEyebrow = document.querySelector("#service-eyebrow");
        const serviceTitle = document.querySelector("#service-title");
        const serviceLead = document.querySelector("#service-lead");
        const serviceList = document.querySelector("#service-list");

        const contactForm = document.querySelector("#contact-form");
        const contactFormStatus = document.querySelector("#contact-form-status");
        const krakowTime = document.querySelector("#krakow-time");

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


        const serviceAltTitles = {
            direction: "Strategia",
            character: "Design",
            presence: "Social Media"
        };

        function serviceTitleMarkup(serviceKey) {
            const service = services[serviceKey];
            const alt = serviceAltTitles[serviceKey] || service.title;
            return `
                <span class="service-title-switch" aria-label="${service.title} / ${alt}">
                    <span class="service-title-switch__track" aria-hidden="true">
                        <span class="service-title-switch__text">${service.title}</span>
                        <span class="service-title-switch__text">${alt}</span>
                    </span>
                </span>
            `;
        }

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

        let currentServiceKey = null;
        let isApplyingHistory = false;

        function normalizedPath() {
            const path = window.location.pathname.replace(/\/+$/, "");
            return path || "/";
        }

        function setRoute(path, replace = false) {
            if (isApplyingHistory || normalizedPath() === path) {
                return;
            }

            try {
                const method = replace ? "replaceState" : "pushState";
                window.history[method]({ path }, "", path);
            } catch (error) {
                /* History API may be restricted when previewing directly from file://.
                   Navigation still works; on a web server the clean routes are enabled. */
            }
        }

        function pillarForService(serviceKey) {
            return document.querySelector(`.pillar[data-service="${serviceKey}"]`);
        }

        function renderServiceLoop(serviceKey) {
            const items = serviceLoop[serviceKey] || [];

            return `
                <nav class="service-loop" aria-label="Pozostałe obszary">
                    ${items.map((item) => `
                        <button
                            class="service-loop__button"
                            type="button"
                            data-next-service="${item.key}"
                            aria-label="Przejdź do: ${item.label}"
                        >
                            <span class="service-loop__label">${item.label}</span>
                            <span class="service-loop__arrow nav-arrow" aria-hidden="true"></span>
                        </button>
                    `).join("")}
                </nav>
            `;
        }

        function renderService(serviceKey) {
            const order = [serviceKey, ...(serviceLoop[serviceKey] || []).map(item => item.key)];
            const firstService = services[serviceKey];

            if (!firstService) {
                return;
            }

            serviceEyebrow.textContent = firstService.eyebrow;
            serviceTitle.innerHTML = serviceTitleMarkup(serviceKey);
            serviceLead.textContent = firstService.lead;

            const renderSteps = (service) => service.steps
                .map((step, index) => {
                    const number = String(index + 1).padStart(2, "0");

                    return `
                        <article class="service-step">
                            <div class="service-step__number">${number}</div>
                            <div>
                                <h3 class="service-step__title">${step.title}</h3>
                                <p class="service-step__tagline">${step.tagline}</p>
                                <p class="service-step__description">${step.description}</p>
                            </div>
                        </article>
                    `;
                })
                .join("");

            serviceList.innerHTML = renderSteps(firstService);

            const inner = servicePanel.querySelector(".service-panel__inner");
            inner.querySelectorAll(".service-continuation, .service-panel__section").forEach((section) => {
                if (section.classList.contains("service-panel__section")) {
                    const intro = section.querySelector(".service-panel__intro");
                    const list = section.querySelector(".service-panel__list");
                    if (intro) inner.insertBefore(intro, section);
                    if (list) inner.insertBefore(list, section);
                }
                section.remove();
            });

            const intro = inner.querySelector(".service-panel__intro");
            const firstList = inner.querySelector(".service-panel__list");
            const firstSection = document.createElement("section");
            firstSection.className = "service-panel__section";
            firstSection.dataset.serviceSection = serviceKey;
            inner.insertBefore(firstSection, intro);
            firstSection.appendChild(intro);
            firstSection.appendChild(firstList);

            order.slice(1).forEach((key, index) => {
                const service = services[key];
                const section = document.createElement("section");
                section.className = "service-continuation";
                section.dataset.serviceSection = key;
                section.dataset.sequence = String(index + 2);
                section.innerHTML = `
                    <header class="service-continuation__header">
                        <div class="service-panel__eyebrow">${service.eyebrow}</div>
                        <h2 class="service-panel__title">${serviceTitleMarkup(key)}</h2>
                        <p class="service-panel__lead">${service.lead}</p>
                    </header>
                    <div class="service-continuation__list">
                        ${renderSteps(service)}
                    </div>
                `;
                inner.appendChild(section);
            });

            const oldMobileCta = inner.querySelector(".service-panel__cta--mobile");
            if (oldMobileCta) oldMobileCta.style.display = "none";

            inner.querySelectorAll(".service-end-cta, .service-panel__end-cta").forEach((cta) => cta.remove());
            const endCta = document.createElement("div");
            endCta.className = "panel-end-cta service-panel__end-cta";
            endCta.innerHTML = `
                <button class="panel-end-cta__button" type="button">
                    <span class="panel-end-cta__eyebrow">Masz projekt?</span>
                    <span class="panel-end-cta__title">Porozmawiajmy <span class="nav-arrow" aria-hidden="true">↗</span></span>
                </button>
            `;
            endCta.querySelector(".panel-end-cta__button").addEventListener("click", openContact);
            inner.appendChild(endCta);

            const sections = [...inner.querySelectorAll("[data-service-section]")];
            let themeFrame = null;
            const updateServiceTheme = () => {
                if (themeFrame) return;
                themeFrame = requestAnimationFrame(() => {
                    const trigger = servicePanel.scrollTop + servicePanel.clientHeight * 0.72;
                    let activeIndex = 0;
                    sections.forEach((section, index) => {
                        if (section.offsetTop <= trigger) activeIndex = index;
                    });
                    servicePanel.classList.toggle("is-inverted", activeIndex === 1);
                    themeFrame = null;
                });
            };

            servicePanel.onscroll = updateServiceTheme;
            updateServiceTheme();
        }

        function syncBodyLock() {
            const anyPanelOpen =
                bioPanel.classList.contains("is-open") ||
                projectsPanel.classList.contains("is-open") ||
                contactPanel.classList.contains("is-open") ||
                servicePanel.classList.contains("is-open");

            document.body.classList.toggle("bio-is-open", anyPanelOpen);
        }

        function closeBio() {
            bioPanel.classList.remove("is-open");
            bioButton.setAttribute("aria-expanded", "false");
            bioPanel.setAttribute("aria-hidden", "true");
            bioButtonLabel.textContent = "[ B I O ]";
            syncBodyLock();
        }

        function closeProjects() {
            projectsPanel.classList.remove("is-open");
            projectsButton.setAttribute("aria-expanded", "false");
            projectsPanel.setAttribute("aria-hidden", "true");
            projectsButtonLabel.textContent = "[ P R O J E K T Y ]";
            syncBodyLock();
        }

        function closeContact() {
            contactPanel.classList.remove("is-open");
            contactButton.setAttribute("aria-expanded", "false");
            contactPanel.setAttribute("aria-hidden", "true");
            contactButtonLabel.textContent = "[ K O N T A K T ]";
            syncBodyLock();
        }

        function closeService() {
            servicePanel.classList.remove("is-open", "is-inverted");
            servicePanel.setAttribute("aria-hidden", "true");
            pillars.forEach((pillar) => pillar.classList.remove("is-active"));
            syncBodyLock();
        }


        function replayEntrance(panel, duration = 900) {
            if (!panel) {
                return;
            }

            panel.classList.remove("is-entering");
            void panel.offsetWidth;
            panel.classList.add("is-entering");

            window.setTimeout(() => {
                panel.classList.remove("is-entering");
            }, duration);
        }

        function animateHomeEntrance() {
            document.body.classList.remove("home-is-entering");
            void document.body.offsetWidth;
            document.body.classList.add("home-is-entering");

            window.setTimeout(() => {
                document.body.classList.remove("home-is-entering");
            }, 1200);
        }

        function openBio() {
            closeProjects();
            closeContact();
            closeService();
            replayEntrance(bioPanel, 1050);
            bioPanel.classList.add("is-open");
            bioButton.setAttribute("aria-expanded", "true");
            bioPanel.setAttribute("aria-hidden", "false");
            bioPanel.scrollTop = 0;
            syncBodyLock();
            setRoute("/bio");
        }

        function openProjects() {
            closeBio();
            closeContact();
            closeService();
            replayEntrance(projectsPanel, 1250);
            projectsPanel.classList.add("is-open");
            projectsButton.setAttribute("aria-expanded", "true");
            projectsPanel.setAttribute("aria-hidden", "false");
            projectsPanel.scrollTop = 0;
            syncBodyLock();
            scheduleProjectsCanvasHeight();
            setRoute("/projekty");
        }

        function openContact() {
            closeBio();
            closeProjects();
            closeService();
            replayEntrance(contactPanel, 1000);
            contactPanel.classList.add("is-open");
            contactButton.setAttribute("aria-expanded", "true");
            contactPanel.setAttribute("aria-hidden", "false");
            contactPanel.scrollTop = 0;
            syncBodyLock();
            setRoute("/kontakt");
        }

        function commitService(serviceKey, pillar) {
            pillars.forEach((item) => item.classList.remove("is-active"));

            if (pillar) {
                pillar.classList.add("is-active");
            }

            currentServiceKey = serviceKey;
            renderService(serviceKey);
            servicePanel.scrollTop = 0;
            setRoute(routeByService[serviceKey]);

            servicePanel.classList.remove("is-switching");
            servicePanel.classList.add("is-entering");

            window.setTimeout(() => {
                servicePanel.classList.remove("is-entering");
            }, 760);
        }

        function openService(serviceKey, pillar) {
            closeBio();
            closeProjects();
            closeContact();

            const serviceAlreadyOpen = servicePanel.classList.contains("is-open");

            if (!serviceAlreadyOpen) {
                commitService(serviceKey, pillar);
                servicePanel.classList.add("is-open");
                servicePanel.setAttribute("aria-hidden", "false");
                replayEntrance(servicePanel, 900);
                syncBodyLock();
                return;
            }

            if (currentServiceKey === serviceKey) {
                servicePanel.scrollTo({ top: 0, behavior: "smooth" });
                return;
            }

            servicePanel.classList.add("is-switching");

            window.setTimeout(() => {
                commitService(serviceKey, pillar);
            }, 260);
        }

        pillars.forEach((pillar) => {
            pillar.addEventListener("click", () => {
                openService(pillar.dataset.service, pillar);
            });
        });

        footerPillars.forEach((pillar) => {
            pillar.addEventListener("click", () => {
                openService(
                    pillar.dataset.service,
                    pillarForService(pillar.dataset.service)
                );
            });
        });

        bioButton.addEventListener("click", openBio);
        areasButton.addEventListener("click", () => {
            openService("direction", pillarForService("direction"));
        });
        projectsButton.addEventListener("click", openProjects);
        contactButton.addEventListener("click", openContact);

        homeLogo.addEventListener("click", (event) => {
            event.preventDefault();
            closeBio();
            closeProjects();
            closeContact();
            closeService();
            setRoute("/");
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        serviceCtas.forEach((button) => button.addEventListener("click", openContact));

        document.addEventListener("keydown", (event) => {
            if (event.key !== "Escape") {
                return;
            }

            if (servicePanel.classList.contains("is-open")) {
                closeService();
                setRoute("/");
                return;
            }

            if (projectsPanel.classList.contains("is-open")) {
                closeProjects();
                setRoute("/");
                projectsButton.focus();
                return;
            }

            if (bioPanel.classList.contains("is-open")) {
                closeBio();
                setRoute("/");
                bioButton.focus();
                return;
            }

            if (contactPanel.classList.contains("is-open")) {
                closeContact();
                setRoute("/");
                contactButton.focus();
            }
        });



        function runSiteIntro() {
            if (!siteIntro || !introLogo) {
                return;
            }

            const DEBUG_INTRO = true;
            const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
            const navbarLogo = document.querySelector(".topbar__studio img");
            const isHomeRoute = normalizedPath() === "/";

            let alreadyShown = false;

            try {
                alreadyShown = sessionStorage.getItem("inflect-intro-shown") === "1";
            } catch (error) {
                alreadyShown = false;
            }

            if (
                reducedMotion ||
                !navbarLogo ||
                !isHomeRoute ||
                (!DEBUG_INTRO && alreadyShown)
            ) {
                siteIntro.remove();
                return;
            }

            document.body.classList.add("intro-is-running");

            const moveLogoToNavbar = () => {
                const targetRect = navbarLogo.getBoundingClientRect();
                const currentRect = introLogo.getBoundingClientRect();

                introLogo.style.left = `${targetRect.left + (targetRect.width / 2)}px`;
                introLogo.style.top = `${targetRect.top + (targetRect.height / 2)}px`;
                introLogo.style.width = `${targetRect.width}px`;
                introLogo.style.transform = "translate(-50%, -50%) scale(1)";

                siteIntro.classList.add("is-moving");
            };

            requestAnimationFrame(() => {
                siteIntro.classList.add("is-visible");
            });

            window.setTimeout(moveLogoToNavbar, 900);

            /* The intro overlay was previously still opaque while the page
               animations were already running. They finished behind it.
               Reveal the page only after the moving logo reaches the navbar. */
            window.setTimeout(() => {
                siteIntro.classList.add("is-revealing");
                document.body.classList.add("intro-elements-visible");
            }, 1960);

            /* Explicit sequence instead of CSS nth-child delays.
               Menu and logos enter first, then hero follows in a faster 600 ms rhythm. */
            window.setTimeout(() => {
                const direction = document.querySelector('.pillar[data-service="direction"]');
                direction?.classList.add("is-intro-revealed");
            }, 2460);

            window.setTimeout(() => {
                const character = document.querySelector('.pillar[data-service="character"]');
                character?.classList.add("is-intro-revealed");
            }, 3260);

            window.setTimeout(() => {
                const presence = document.querySelector('.pillar[data-service="presence"]');
                presence?.classList.add("is-intro-revealed");
            }, 3860);

            window.setTimeout(() => {
                document.body.classList.add("hero-pillars-ready");
            }, 4380);

            window.setTimeout(() => {
                document.querySelector(".topbar__studio").style.opacity = "1";
                siteIntro.classList.add("is-finished");

                try {
                    sessionStorage.setItem("inflect-intro-shown", "1");
                } catch (error) {
                    /* Storage can be unavailable in private/local previews. */
                }
            }, 4900);

            window.setTimeout(() => {
                document.body.classList.remove("intro-is-running");
                document.querySelectorAll(".pillar.is-intro-revealed").forEach((pillar) => {
                    pillar.classList.remove("is-intro-revealed");
                });
                siteIntro.remove();
            }, 5200);
        }

        function showHomeFromHistory() {
            closeBio();
            closeProjects();
            closeContact();
            closeService();
            window.scrollTo({ top: 0, behavior: "auto" });
            animateHomeEntrance();
        }

        function applyRouteFromLocation() {
            const path = normalizedPath();
            isApplyingHistory = true;

            if (path === "/bio") {
                openBio();
            } else if (path === "/projekty") {
                openProjects();
            } else if (path === "/kontakt") {
                openContact();
            } else if (serviceByRoute[path]) {
                const key = serviceByRoute[path];
                openService(key, pillarForService(key));
            } else {
                showHomeFromHistory();
            }

            isApplyingHistory = false;
        }

        window.addEventListener("popstate", applyRouteFromLocation);
        applyRouteFromLocation();
        runSiteIntro();


        function updateProjectsCanvasHeight() {
            const canvas = document.querySelector(".projects-panel__canvas");

            if (!canvas) {
                return;
            }

            const images = Array.from(canvas.querySelectorAll("img, video"));

            if (!images.length) {
                return;
            }

            const canvasTop = canvas.getBoundingClientRect().top;
            let maxBottom = 0;

            images.forEach((image) => {
                const rect = image.getBoundingClientRect();
                maxBottom = Math.max(maxBottom, rect.bottom - canvasTop);
            });

            canvas.style.height = `${Math.ceil(maxBottom + 80)}px`;
        }

        function scheduleProjectsCanvasHeight() {
            requestAnimationFrame(() => {
                requestAnimationFrame(updateProjectsCanvasHeight);
            });
        }

        document.querySelectorAll(".projects-panel__canvas img, .projects-panel__canvas video").forEach((media) => {
            if (media.tagName === "VIDEO") {
                if (media.readyState >= 1) scheduleProjectsCanvasHeight();
                else media.addEventListener("loadedmetadata", scheduleProjectsCanvasHeight, { once: true });
                media.addEventListener("error", scheduleProjectsCanvasHeight, { once: true });
            } else if (media.complete) {
                scheduleProjectsCanvasHeight();
            } else {
                media.addEventListener("load", scheduleProjectsCanvasHeight, { once: true });
                media.addEventListener("error", scheduleProjectsCanvasHeight, { once: true });
            }
        });

        window.addEventListener("resize", scheduleProjectsCanvasHeight);

        document.querySelectorAll(".js-open-contact").forEach((button) => {
            button.addEventListener("click", openContact);
        });

        function updateKrakowTime() {
            const formatted = new Intl.DateTimeFormat("pl-PL", {
                timeZone: "Europe/Warsaw",
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
                hour12: false
            }).format(new Date());

            krakowTime.textContent = formatted;
        }
updateKrakowTime();
        window.setInterval(updateKrakowTime, 1000);

        contactForm.addEventListener("submit", (event) => {
            event.preventDefault();

            const data = new FormData(contactForm);
            const subject = encodeURIComponent(
                `Nowe zapytanie — ${data.get("name") || "Inflect Studio"}`
            );

            const body = encodeURIComponent(
                [
                    `Imię i nazwisko: ${data.get("name") || ""}`,
                    `E-mail: ${data.get("email") || ""}`,
                    `Budżet: ${data.get("budget") || "Nie określono"}`,
                    "",
                    "Opis projektu:",
                    data.get("message") || ""
                ].join("\n")
            );

            contactFormStatus.textContent =
                "Otwieram wiadomość w Twoim programie pocztowym…";

            window.location.href =
                `mailto:hello@inflect.studio?subject=${subject}&body=${body}`;
        });
    
(function(){
const stage=document.createElement('div');
stage.className='hero-hover-stage';
const card=document.createElement('div');
card.className='hero-hover-image';
const img=document.createElement('img');
card.appendChild(img);
stage.appendChild(card);
document.querySelector('.hero')?.appendChild(stage);

const folders={
 direction:'strategia',
 character:'design',
 presence:'sm'
};

let raf=0,targetX=0,targetY=0,currentX=0,currentY=0;

function tick(){
 currentX+=(targetX-currentX)*0.11;
 currentY+=(targetY-currentY)*0.11;
 card.style.transform=`translate(calc(-50% + ${currentX}px),calc(-50% + ${currentY}px)) scale(1)`;
 raf=requestAnimationFrame(tick);
}

document.querySelectorAll('.pillar').forEach(p=>{
 p.addEventListener('mouseenter',()=>{
   if (!document.body.classList.contains('hero-pillars-ready')) return;
   const r=p.getBoundingClientRect();
   const hr=document.querySelector('.hero').getBoundingClientRect();
   card.style.left=(r.left+r.width/2-hr.left)+'px';
   card.style.top=(r.top+r.height/2-hr.top)+'px';
   const key=folders[p.dataset.service];
   const n=Math.floor(Math.random()*3)+1;
   img.src=`assets/hero/${key}-hero-${n}.jpg`;
   card.style.opacity='1';
   currentX=currentY=targetX=targetY=0;
   cancelAnimationFrame(raf);
   tick();
 });
 p.addEventListener('mousemove',(e)=>{
   if (!document.body.classList.contains('hero-pillars-ready')) return;
   const r=p.getBoundingClientRect();
   targetX=((e.clientX-(r.left+r.width/2))/r.width)*42;
   targetY=((e.clientY-(r.top+r.height/2))/r.height)*28;
 });
 p.addEventListener('mouseleave',()=>{
   card.style.opacity='0';
   cancelAnimationFrame(raf);
 });
});
})();

</script>


<script id="inflect-projects-motion">
(() => {
    const panel = document.querySelector('.projects-panel');
    const canvas = document.querySelector('#projects-canvas');
    if (!panel || !canvas) return;

    const items = [...canvas.querySelectorAll('.project-media')];
    const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

    // Stable pseudo-random values: the composition feels organic but does not jump on resize.
    const random = index => {
        const x = Math.sin((index + 1) * 127.1 + 311.7) * 43758.5453;
        return x - Math.floor(x);
    };

    function ratioFor(item) {
        const media = item.querySelector('img, video');
        if (!media) return .78;
        if (media.tagName === 'VIDEO' && media.videoWidth && media.videoHeight) {
            return media.videoHeight / media.videoWidth;
        }
        if (media.naturalWidth && media.naturalHeight) {
            return media.naturalHeight / media.naturalWidth;
        }
        return item.classList.contains('project-media--video') ? 1.25 : .78;
    }

    function layout() {
        const mobile = window.innerWidth <= 720;
        const viewport = panel.clientWidth || window.innerWidth;
        const topStart = mobile ? 72 : 104;
        const bandGap = mobile ? 92 : clamp(viewport * .085, 118, 184);
        let y = topStart;
        let i = 0;

        while (i < items.length) {
            if (mobile) {
                const item = items[i];
                const width = 72 + random(i * 5) * 20;
                const maxLeft = 100 - width - 4;
                const left = 4 + random(i * 5 + 1) * Math.max(maxLeft - 4, 0);
                const ratio = clamp(ratioFor(item), .52, 1.55);
                const height = viewport * (width / 100) * ratio;
                const stagger = random(i * 5 + 2) * 34;

                item.style.setProperty('--x', `${left.toFixed(2)}%`);
                item.style.setProperty('--w', `${width.toFixed(2)}%`);
                item.style.setProperty('--y', `${(y + stagger).toFixed(0)}px`);
                item.style.setProperty('--tilt', `${((random(i * 5 + 3) - .5) * .7).toFixed(2)}deg`);
                item.style.setProperty('--z', String(1 + (i % 3)));
                item.dataset.depth = (.62 + random(i * 5 + 4) * .48).toFixed(2);
                item.dataset.axis = i % 2 ? '1' : '-1';

                y += height + stagger + bandGap;
                i += 1;
                continue;
            }

            // Desktop: alternating two-item editorial bands and occasional solo feature.
            const solo = i % 7 === 5 || (items.length - i === 1);
            if (solo) {
                const item = items[i];
                const width = 48 + random(i * 7) * 12;
                const left = random(i * 7 + 1) > .5
                    ? 5 + random(i * 7 + 2) * 8
                    : 100 - width - 5 - random(i * 7 + 2) * 8;
                const ratio = clamp(ratioFor(item), .5, 1.45);
                const height = viewport * (width / 100) * ratio;

                item.style.setProperty('--x', `${left.toFixed(2)}%`);
                item.style.setProperty('--w', `${width.toFixed(2)}%`);
                item.style.setProperty('--y', `${y.toFixed(0)}px`);
                item.style.setProperty('--tilt', `${((random(i * 7 + 3) - .5) * .55).toFixed(2)}deg`);
                item.style.setProperty('--z', '2');
                item.dataset.depth = (.68 + random(i * 7 + 4) * .42).toFixed(2);
                item.dataset.axis = left < 30 ? '-1' : '1';

                y += height + bandGap * 1.08;
                i += 1;
                continue;
            }

            const pair = items.slice(i, i + 2);
            let bandHeight = 0;
            pair.forEach((item, column) => {
                const seed = i * 11 + column * 5;
                const width = column === 0
                    ? 31 + random(seed) * 12
                    : 29 + random(seed + 1) * 13;
                const left = column === 0
                    ? 4 + random(seed + 2) * 10
                    : 100 - width - 4 - random(seed + 3) * 10;
                const offset = column === 0
                    ? random(seed + 4) * 54
                    : 72 + random(seed + 5) * 112;
                const ratio = clamp(ratioFor(item), .52, 1.55);
                const height = viewport * (width / 100) * ratio;

                item.style.setProperty('--x', `${left.toFixed(2)}%`);
                item.style.setProperty('--w', `${width.toFixed(2)}%`);
                item.style.setProperty('--y', `${(y + offset).toFixed(0)}px`);
                item.style.setProperty('--tilt', `${((random(seed + 6) - .5) * .75).toFixed(2)}deg`);
                item.style.setProperty('--z', String(1 + ((i + column) % 3)));
                item.dataset.depth = (.58 + random(seed + 7) * .55).toFixed(2);
                item.dataset.axis = column === 0 ? '-1' : '1';

                bandHeight = Math.max(bandHeight, offset + height);
            });

            y += bandHeight + bandGap;
            i += pair.length;
        }

        canvas.style.height = `${Math.ceil(y + (mobile ? 80 : 150))}px`;
        requestFrame();
    }

    items.forEach(item => {
        const media = item.querySelector('img, video');
        if (!media) return;
        if (media.tagName === 'IMG') media.addEventListener('load', layout, { once: true });
        else media.addEventListener('loadedmetadata', layout, { once: true });
    });

    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        });
    }, { root: panel, rootMargin: '8% 0px -8% 0px', threshold: .05 });
    items.forEach(item => revealObserver.observe(item));

    // Videos are attached shortly before entering the viewport, not on initial page load.
    const videos = [...canvas.querySelectorAll('video')];
    videos.forEach(video => {
        video.muted = true;
        video.defaultMuted = true;
        video.loop = true;
        video.playsInline = true;
        video.controls = false;
        video.disablePictureInPicture = true;
    });

    const videoObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            const video = entry.target;
            if (entry.isIntersecting) {
                if (!video.src && video.dataset.src) {
                    video.src = video.dataset.src;
                    video.preload = 'auto';
                    video.load();
                }
                const play = () => video.play().catch(() => {});
                if (video.readyState >= 2) play();
                else video.addEventListener('canplay', play, { once: true });
            } else {
                video.pause();
            }
        });
    }, { root: panel, rootMargin: '1100px 0px 1100px 0px', threshold: 0 });
    videos.forEach(video => videoObserver.observe(video));

    let pointerX = 0;
    let pointerY = 0;
    let touchX = 0;
    let touchY = 0;
    let lastTouchX = 0;
    let lastTouchY = 0;
    let raf = 0;

    function render() {
        const panelRect = panel.getBoundingClientRect();
        const centerY = panelRect.top + panel.clientHeight / 2;
        const mobile = window.innerWidth <= 720;

        items.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const depth = Number(item.dataset.depth || .8);
            const axis = Number(item.dataset.axis || 1);
            const distance = (rect.top + rect.height / 2 - centerY) / Math.max(panel.clientHeight, 1);
            const parallax = -distance * (mobile ? 42 : 72) * depth;
            const gestureX = (pointerX * (mobile ? 0 : 13) + touchX * 18) * depth * axis;
            const gestureY = (pointerY * (mobile ? 0 : 8) + touchY * 8) * depth;
            const driftX = Math.sin((panel.scrollTop * .0015) + index * .9) * (mobile ? 2.5 : 4.5) * depth;

            item.style.setProperty('--parallax-y', `${parallax.toFixed(2)}px`);
            item.style.setProperty('--gesture-x', `${gestureX.toFixed(2)}px`);
            item.style.setProperty('--gesture-y', `${gestureY.toFixed(2)}px`);
            item.style.setProperty('--drift-x', `${driftX.toFixed(2)}px`);
        });

        touchX *= .86;
        touchY *= .86;
        raf = 0;
        if (Math.abs(touchX) > .01 || Math.abs(touchY) > .01) requestFrame();
    }

    function requestFrame() {
        if (!raf) raf = requestAnimationFrame(render);
    }

    panel.addEventListener('scroll', requestFrame, { passive: true });
    panel.addEventListener('pointermove', event => {
        if (event.pointerType === 'touch') return;
        pointerX = (event.clientX / window.innerWidth - .5) * 2;
        pointerY = (event.clientY / window.innerHeight - .5) * 2;
        requestFrame();
    }, { passive: true });
    panel.addEventListener('pointerleave', () => {
        pointerX = 0;
        pointerY = 0;
        requestFrame();
    }, { passive: true });

    panel.addEventListener('touchstart', event => {
        const touch = event.touches[0];
        if (!touch) return;
        lastTouchX = touch.clientX;
        lastTouchY = touch.clientY;
    }, { passive: true });

    panel.addEventListener('touchmove', event => {
        const touch = event.touches[0];
        if (!touch) return;
        const dx = clamp((touch.clientX - lastTouchX) / 22, -1, 1);
        const dy = clamp((touch.clientY - lastTouchY) / 34, -1, 1);
        touchX = dx;
        touchY = dy;
        lastTouchX = touch.clientX;
        lastTouchY = touch.clientY;
        requestFrame();
    }, { passive: true });

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(layout, 120);
    }, { passive: true });

    layout();
    requestFrame();
})();
</script>

</body>
</html>
