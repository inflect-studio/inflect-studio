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