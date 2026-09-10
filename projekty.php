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
    <title>Projekty — Inflect Studio</title>
    <link rel="stylesheet" href="assets/css/site.css">
</head>
<body class="page-projects">

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


            <a class="panel-end-cta__button projects-panel__cta js-open-contact" href="kontakt.php">
                <span class="panel-end-cta__eyebrow">Masz projekt?</span>
                <span class="panel-end-cta__title">Porozmawiajmy <span class="nav-arrow" aria-hidden="true"></span></span>
            </a>
        </div>
    </section>    <section
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

                <a class="service-panel__cta service-panel__cta--desktop" href="kontakt.php">
                    <span>Masz projekt?</span>
                    <strong>Porozmawiajmy <span class="nav-arrow" aria-hidden="true"></span></strong>
                </a>
            </div>

            <div
                class="service-panel__list"
                id="service-list"
                aria-live="polite"
            ></div>

            <a class="service-panel__cta service-panel__cta--mobile" href="kontakt.php">
                <span>Masz projekt?</span>
                <strong>Porozmawiajmy <span class="nav-arrow" aria-hidden="true"></span></strong>
            </a>
        </div>
    </section>
</div>
<script src="assets/js/site.js" defer></script>
<script src="assets/js/projects.js" defer></script>
</body>
</html>
