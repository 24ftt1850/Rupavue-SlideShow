<div class="rv-themes">
    @php
        /*
         * Each card floats at its own position around the centred heading.
         * x / y are the card's centre point as a percentage of the slide.
         */
        $themes = [
            [
                'image' => 'anime.jpg',
                'category' => 'ANIMATION',
                'name' => 'Anime Universe',
                'description' => 'Step into your favourite anime world.',
                'x' => '11%', 'y' => '33%', 'rotate' => '-6deg', 'scale' => '.95', 'duration' => '7s', 'delay' => '-1s',
            ],
            [
                'image' => 'cyberpunk.jpg',
                'category' => 'SCI-FI',
                'name' => 'Cyberpunk City',
                'description' => 'A futuristic world filled with neon lights and technology.',
                'x' => '27%', 'y' => '25%', 'rotate' => '5deg', 'scale' => '.8', 'duration' => '8.5s', 'delay' => '-4s',
            ],
            [
                'image' => 'fantasy.jpg',
                'category' => 'IMAGINATION',
                'name' => 'Fantasy Realm',
                'description' => 'Discover extraordinary scenes in a magical world.',
                'x' => '22%', 'y' => '74%', 'rotate' => '-3deg', 'scale' => '1', 'duration' => '6.5s', 'delay' => '-2.5s',
            ],
            [
                'image' => 'graduation.jpg',
                'category' => 'MILESTONES',
                'name' => 'Graduation',
                'description' => 'Celebrate your achievements with a memorable portrait.',
                'x' => '73%', 'y' => '25%', 'rotate' => '-5deg', 'scale' => '.8', 'duration' => '8s', 'delay' => '-3s',
            ],
            [
                'image' => 'mafia.jpg',
                'category' => 'CINEMATIC',
                'name' => 'Crime Boss',
                'description' => 'Enter a cinematic world of power and elegance.',
                'x' => '89%', 'y' => '33%', 'rotate' => '6deg', 'scale' => '.95', 'duration' => '7.5s', 'delay' => '-5s',
            ],
            [
                'image' => 'warrior.jpg',
                'category' => 'LEGENDS',
                'name' => 'Warrior Legacy',
                'description' => 'Embrace the legacy of powerful warriors.',
                'x' => '78%', 'y' => '74%', 'rotate' => '3deg', 'scale' => '1', 'duration' => '6.8s', 'delay' => '-1.5s',
            ],
        ];
    @endphp

    <header class="rv-themes-heading">
        <div class="rv-themes-halo" aria-hidden="true"></div>

        <span class="rv-themes-eyebrow">{{ count($themes) }} STYLES · ONE TAP</span>

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

    <div class="rv-theme-field" data-theme-field>
        @foreach ($themes as $index => $theme)
            <div
                class="rv-theme-slot"
                style="--x: {{ $theme['x'] }}; --y: {{ $theme['y'] }}; --rotate: {{ $theme['rotate'] }}; --scale: {{ $theme['scale'] }}; --float-duration: {{ $theme['duration'] }}; --float-delay: {{ $theme['delay'] }}; --enter-delay: {{ $index * 0.12 }}s;"
            >
                <div class="rv-theme-float">
                    <article class="rv-theme-card" data-theme-card>
                        <div class="rv-theme-image">
                            <img
                                src="{{ asset('images/themes/' . $theme['image']) }}"
                                alt="{{ $theme['name'] }}"
                            >
                            <div class="rv-theme-image-shade"></div>
                        </div>

                        <div class="rv-theme-info">
                            <span class="rv-theme-category">
                                {{ $theme['category'] }}
                            </span>

                            <h2>{{ $theme['name'] }}</h2>

                            <p>{{ $theme['description'] }}</p>
                        </div>
                    </article>

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
        width: min(15vw, 28vh);
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

    /* Card: entrance and spotlight */
    .rv-theme-card {
        position: relative;
        aspect-ratio: 3 / 4;
        overflow: hidden;
        border: 1.5px solid rgba(69, 179, 255, .8);
        border-radius: 24px;
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

    .rv-theme-image {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    .rv-theme-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform 1.2s ease;
    }

    .rv-theme-card.is-featured .rv-theme-image img {
        transform: scale(1.06);
    }

    .rv-theme-image-shade {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(2, 7, 22, 0) 30%,
            rgba(2, 7, 22, .2) 50%,
            rgba(2, 7, 22, .94) 100%
        );
    }

    .rv-theme-info {
        position: absolute;
        z-index: 1;
        left: 8%;
        right: 8%;
        bottom: 7%;
        color: #f7fbff;
    }

    .rv-theme-category {
        display: inline-block;
        margin-bottom: 6px;
        color: #48dce5;
        font-size: clamp(9px, .7vw, 12px);
        font-weight: 800;
        letter-spacing: 1.2px;
    }

    .rv-theme-info h2 {
        margin: 0;
        color: #fff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(17px, 1.5vw, 26px);
        line-height: 1.05;
        font-weight: 700;
        text-shadow: 0 2px 12px #020716;
    }

    /* Description reveals only on the featured card */
    .rv-theme-info p {
        max-height: 0;
        margin: 0;
        overflow: hidden;
        opacity: 0;
        color: #d9e8ff;
        font-size: clamp(10px, .8vw, 13px);
        line-height: 1.4;
        transition:
            max-height .8s ease,
            margin .8s ease,
            opacity .8s ease;
    }

    .rv-theme-card.is-featured .rv-theme-info p {
        max-height: 4.2em;
        margin-top: 8px;
        opacity: 1;
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
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
