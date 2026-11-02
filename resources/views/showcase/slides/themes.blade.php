@inject('floatingCardLayout', 'App\Services\FloatingCardLayout')

<div class="rv-themes">
    @php
        /*
         * One floating card for every photo in the Google Drive folder,
         * spread around the centred heading. Cards shrink as the folder grows.
         */
        $themePhotos = $themePhotos ?? [];
        $layout = $floatingCardLayout->arrange(count($themePhotos));
    @endphp

    <header class="rv-themes-heading">
        <div class="rv-themes-halo" aria-hidden="true"></div>

        @if (count($themePhotos))
            <span class="rv-themes-eyebrow">{{ count($themePhotos) }} STYLES · ONE TAP</span>
        @endif

        <h1>
            Multiple <span>AI</span><br>
            <span>Theme</span> Available
        </h1>

        <div class="rv-themes-footer">
            <span>RUPAVUE</span>
            <span class="rv-footer-dot"></span>
            YOUR STYLE, REIMAGINED
        </div>
    </header>

    <div
        class="rv-theme-field"
        data-theme-field
        style="--columns: {{ $layout['columns'] }}; --rows: {{ $layout['rows'] }};"
    >
        @foreach ($themePhotos as $index => $photo)
            @php($slot = $layout['slots'][$index])

            <div
                class="rv-theme-slot"
                style="--x: {{ $slot['x'] }}%; --y: {{ $slot['y'] }}%; --rotate: {{ $slot['rotate'] }}deg; --scale: {{ $slot['scale'] }}; --float-duration: {{ $slot['duration'] }}s; --float-delay: {{ $slot['delay'] }}s; --enter-delay: {{ round($index * 0.05, 2) }}s;"
            >
                <div class="rv-theme-float">
                    <div class="rv-theme-card" data-theme-card>
                        <img
                            class="rv-theme-photo"
                            src="{{ $photo['url'] }}"
                            alt="AI theme example"
                            referrerpolicy="no-referrer"
                            data-theme-photo
                        >
                    </div>

                    <div class="rv-theme-shadow" aria-hidden="true"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('showcase-styles')
<style>
    /* The existing galaxy background stays in layouts/showcase.blade.php */

    .rv-themes {
        position: relative;
        width: 100%;
        height: 100%;
    }

    /* CENTRED HEADING */
    .rv-themes-heading {
        position: absolute;
        z-index: 2;
        top: 48%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .rv-themes-halo {
        position: absolute;
        z-index: -1;
        top: 50%;
        left: 50%;
        width: clamp(260px, 26vw, 460px);
        aspect-ratio: 1;
        transform: translate(-50%, -50%);
        border: 1px solid rgba(72, 220, 229, .25);
        border-radius: 50%;
        background: radial-gradient(
            circle,
            rgba(0, 110, 255, .28),
            rgba(0, 60, 160, .08) 55%,
            transparent 70%
        );
        box-shadow:
            0 0 60px rgba(0, 120, 255, .18),
            inset 0 0 40px rgba(72, 220, 229, .08);
        animation: rv-halo-pulse 6s ease-in-out infinite;
    }

    @keyframes rv-halo-pulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: .8;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.06);
            opacity: 1;
        }
    }

    .rv-themes-eyebrow {
        display: inline-block;
        margin-bottom: 14px;
        color: #48dce5;
        font-size: clamp(9px, .75vw, 12px);
        font-weight: 800;
        letter-spacing: 3px;
    }

    .rv-themes-heading h1 {
        margin: 0;
        color: #f7fbff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(34px, 3.6vw, 62px);
        font-weight: 700;
        line-height: .95;
        letter-spacing: -1.8px;
        white-space: nowrap;
        text-shadow: 0 0 25px rgba(0, 140, 255, .25);
    }

    .rv-themes-heading h1 span {
        color: #53e1eb;
    }

    .rv-themes-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 22px;
        color: #a9c7e9;
        font-size: clamp(9px, .75vw, 12px);
        font-weight: 600;
        letter-spacing: 2.5px;
        white-space: nowrap;
    }

    .rv-themes-footer > span:first-child {
        color: #53e1eb;
        font-weight: 900;
    }

    .rv-footer-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #48dce5;
        box-shadow: 0 0 10px #48dce5;
    }

    /* FLOATING CARDS */
    .rv-theme-field {
        position: absolute;
        inset: 0;
    }

    /* Slot: fixed position, tilt and depth */
    .rv-theme-slot {
        position: absolute;
        top: var(--y);
        left: var(--x);
        /* Fill most of a grid cell; the field is about 92vh tall */
        width: min(calc(82% / var(--columns)), calc(110vh / var(--rows)));
        transform: translate(-50%, -50%) rotate(var(--rotate)) scale(var(--scale));
    }

    /* Float: gentle continuous bobbing, each card at its own pace */
    .rv-theme-float {
        animation: rv-theme-bob var(--float-duration) ease-in-out var(--float-delay) infinite;
    }

    @keyframes rv-theme-bob {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
        }
        30% {
            transform: translate(4px, -14px) rotate(.8deg);
        }
        65% {
            transform: translate(-3px, -6px) rotate(-.6deg);
        }
    }

    /* Card: 6:4 landscape frame (a 4x6 print), entrance and spotlight */
    .rv-theme-card {
        position: relative;
        aspect-ratio: 6 / 4;
        overflow: hidden;
        border: 1.5px solid rgba(69, 179, 255, .8);
        border-radius: clamp(8px, 1.2vw, 20px);
        background: #06152f;
        box-shadow:
            0 0 12px rgba(0, 140, 255, .45),
            0 0 32px rgba(0, 100, 255, .18),
            inset 0 0 15px rgba(30, 145, 255, .12);
        filter: brightness(.82) saturate(.9);
        transition:
            transform .9s cubic-bezier(.2, .8, .2, 1),
            filter .9s ease,
            box-shadow .9s ease,
            border-color .9s ease;
    }

    .rv-slide.active .rv-theme-card {
        animation: rv-theme-drift-in 1.2s cubic-bezier(.2, .8, .2, 1) var(--enter-delay) backwards;
    }

    @keyframes rv-theme-drift-in {
        from {
            opacity: 0;
            transform: translateY(60px) scale(.85);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .rv-theme-card.is-featured {
        transform: translateY(-12px) scale(1.08);
        border-color: #48dce5;
        filter: brightness(1.05) saturate(1.1);
        box-shadow:
            0 0 18px rgba(72, 220, 229, .9),
            0 0 50px rgba(0, 130, 255, .55),
            inset 0 0 18px rgba(72, 220, 229, .2);
    }

    /* Soft glow on the "ground" beneath each floating card */
    .rv-theme-shadow {
        width: 70%;
        height: 14px;
        margin: 18px auto 0;
        border-radius: 50%;
        background: radial-gradient(
            ellipse,
            rgba(0, 140, 255, .45),
            transparent 70%
        );
        filter: blur(4px);
        animation: rv-theme-shadow var(--float-duration) ease-in-out var(--float-delay) infinite;
    }

    @keyframes rv-theme-shadow {
        0%, 100% {
            transform: scaleX(1);
            opacity: .8;
        }
        30% {
            transform: scaleX(.8);
            opacity: .45;
        }
    }

    .rv-theme-photo {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 1.2s ease;
    }

    .rv-theme-card.is-featured .rv-theme-photo {
        transform: scale(1.06);
    }

    /* Lift the spotlighted card above its neighbours */
    .rv-theme-slot:has(.is-featured) {
        z-index: 1;
    }

    /* Pause movement when this slide is not visible */
    .rv-slide:not(.active) .rv-theme-float,
    .rv-slide:not(.active) .rv-theme-shadow,
    .rv-slide:not(.active) .rv-themes-halo {
        animation-play-state: paused;
    }

    @media (max-width: 760px) {
        .rv-themes {
            display: flex;
            flex-direction: column;
            gap: 30px;
            height: auto;
        }

        .rv-themes-heading {
            position: relative;
            top: auto;
            left: auto;
            transform: none;
        }

        .rv-themes-heading h1 {
            font-size: 34px;
            white-space: normal;
        }

        .rv-themes-footer {
            white-space: normal;
        }

        .rv-theme-field {
            position: relative;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px 18px;
        }

        .rv-theme-slot {
            position: relative;
            top: auto;
            left: auto;
            width: 100%;
            transform: rotate(var(--rotate));
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rv-theme-float,
        .rv-theme-shadow,
        .rv-themes-halo,
        .rv-slide.active .rv-theme-card {
            animation: none;
        }
    }
</style>
@endpush

@push('showcase-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slide = document.getElementById('themesSlide');

    if (!slide) {
        return;
    }

    const cards = Array.from(slide.querySelectorAll('[data-theme-card]'));
    const interval = 2500;
    let featuredIndex = -1;
    let timer = null;

    // Hide the card of any photo that fails to load.
    cards.forEach(function (card) {
        card.querySelector('[data-theme-photo]').addEventListener('error', function () {
            card.closest('.rv-theme-slot').hidden = true;
        });
    });

    // Spotlight one card at a time.
    function featureNextCard() {
        if (featuredIndex >= 0) {
            cards[featuredIndex].classList.remove('is-featured');
        }

        featuredIndex = (featuredIndex + 1) % cards.length;
        cards[featuredIndex].classList.add('is-featured');
    }

    function startSpotlight() {
        if (timer || cards.length === 0) {
            return;
        }

        // The first spotlight waits for the cards to finish drifting in.
        timer = window.setInterval(featureNextCard, interval);
    }

    function stopSpotlight() {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    }

    // Run only while this slide is visible.
    const observer = new MutationObserver(function () {
        if (slide.classList.contains('active')) {
            startSpotlight();
        } else {
            stopSpotlight();
        }
    });

    observer.observe(slide, {
        attributes: true,
        attributeFilter: ['class']
    });

    if (slide.classList.contains('active')) {
        startSpotlight();
    }
});
</script>
@endpush
