
<div class="rv-latest">
    <!-- FIXED TITLE -->
    <header class="rv-latest-heading">
        <h1>Latest <span>Generated</span></h1>
        <div class="rv-heading-line"></div>
    </header>

    @php
        /*
         * Newest photos from the booth's Google Drive folder, newest first.
         * They alternate between the stacks so the two newest are both in front.
         */
        $latestPhotos = $latestPhotos ?? [];
        $leftPhotos = array_values(array_filter($latestPhotos, fn (int $index): bool => $index % 2 === 0, ARRAY_FILTER_USE_KEY));
        $rightPhotos = array_values(array_filter($latestPhotos, fn (int $index): bool => $index % 2 === 1, ARRAY_FILTER_USE_KEY));
    @endphp

    @if (empty($latestPhotos))
        <p class="rv-latest-empty">New photos from the booth will appear here.</p>
    @endif

    <!-- LEFT PHOTO STACK -->
    <div class="rv-photo-stack rv-photo-stack-left" data-photo-stack>
        @foreach ($leftPhotos as $index => $photo)
            <div class="rv-photo-card" data-depth="{{ $index }}">
                <img
                    src="{{ $photo['url'] }}"
                    alt="Latest generated photo"
                    loading="eager"
                    referrerpolicy="no-referrer"
                >
                <div class="rv-photo-glow"></div>
            </div>
        @endforeach
    </div>

    <!-- RIGHT PHOTO STACK -->
    <div class="rv-photo-stack rv-photo-stack-right" data-photo-stack>
        @foreach ($rightPhotos as $index => $photo)
            <div class="rv-photo-card" data-depth="{{ $index }}">
                <img
                    src="{{ $photo['url'] }}"
                    alt="Latest generated photo"
                    loading="eager"
                    referrerpolicy="no-referrer"
                >
                <div class="rv-photo-glow"></div>
            </div>
        @endforeach
    </div>

    <!-- SHARED BACKGROUND IS IN layouts/showcase.blade.php -->
</div>

@push('showcase-styles')
<style>
    .rv-latest {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    /* TITLE */
    .rv-latest-heading {
        position: absolute;
        z-index: 10;
        top: 8%;
        left: 0;
        width: 100%;
        text-align: center;
        pointer-events: none;
    }

    .rv-latest-heading h1 {
        margin: 0;
        color: #f7fbff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(36px, 4.5vw, 68px);
        font-weight: 700;
        letter-spacing: -1.5px;
        text-shadow: 0 0 24px rgba(0, 110, 255, .25);
    }

    .rv-latest-heading h1 span {
        color: #48dce5;
        text-shadow: 0 0 22px rgba(0, 190, 255, .3);
    }

    .rv-heading-line {
        width: 48%;
        max-width: 650px;
        height: 2px;
        margin: 18px auto 0;
        background: linear-gradient(
            90deg,
            transparent,
            #078cff,
            #48dce5,
            #078cff,
            transparent
        );
        box-shadow: 0 0 12px rgba(0, 140, 255, .65);
    }

    .rv-latest-empty {
        position: absolute;
        top: 55%;
        left: 0;
        width: 100%;
        color: #a9c7e9;
        font-size: clamp(14px, 1.3vw, 20px);
        letter-spacing: 2px;
        text-align: center;
    }

    /* TWO PHOTO STACKS (width capped by height so they fit short screens) */
    .rv-photo-stack {
        position: absolute;
        top: 34%;
        width: min(40%, 78vh);
        aspect-ratio: 3 / 2;
        perspective: 1200px;
    }

    .rv-photo-stack-left {
        left: 0;
    }

    .rv-photo-stack-right {
        right: 0;
    }

    /* EACH PHOTO USES A 6:4 LANDSCAPE RATIO AND FILLS ITS STACK */
    .rv-photo-card {
        position: absolute;
        inset: 0;
        overflow: hidden;
        border: 1.5px solid rgba(69, 179, 255, .9);
        border-radius: 20px;
        background: #06152f;
        transition:
            transform 900ms cubic-bezier(.2, .8, .2, 1),
            opacity 900ms ease,
            filter 900ms ease,
            box-shadow 900ms ease;
        will-change: transform, opacity;
    }

    /* Show the whole photo; any spare space shows the card's dark background */
    .rv-photo-card img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .rv-photo-glow {
        position: absolute;
        inset: 0;
        pointer-events: none;
        border-radius: inherit;
        background: linear-gradient(
            to bottom,
            rgba(72, 220, 229, .08),
            transparent 35%,
            rgba(2, 7, 22, .35)
        );
        box-shadow: inset 0 0 22px rgba(0, 140, 255, .25);
    }

    /* Newest photo at the front */
    .rv-photo-card[data-depth="0"] {
        z-index: 5;
        opacity: 1;
        transform: translate(0, 0) scale(1);
        filter: brightness(1);
        box-shadow:
            0 0 16px rgba(0, 190, 255, .95),
            0 0 38px rgba(0, 100, 255, .5);
    }

    /* Older photos recede into the background */
    .rv-photo-card[data-depth="1"] {
        z-index: 4;
        opacity: .85;
        transform: translate(7%, -5%) scale(.94);
        filter: brightness(.8);
    }

    .rv-photo-card[data-depth="2"] {
        z-index: 3;
        opacity: .68;
        transform: translate(14%, -10%) scale(.88);
        filter: brightness(.65);
    }

    .rv-photo-card[data-depth="3"] {
        z-index: 2;
        opacity: .48;
        transform: translate(21%, -15%) scale(.82);
        filter: brightness(.5);
    }

    .rv-photo-card[data-depth="4"] {
        z-index: 1;
        opacity: .3;
        transform: translate(28%, -20%) scale(.76);
        filter: brightness(.4);
    }

    /* Reverse the direction for the right-hand stack */
    .rv-photo-stack-right .rv-photo-card[data-depth="1"] {
        transform: translate(-7%, -5%) scale(.94);
    }

    .rv-photo-stack-right .rv-photo-card[data-depth="2"] {
        transform: translate(-14%, -10%) scale(.88);
    }

    .rv-photo-stack-right .rv-photo-card[data-depth="3"] {
        transform: translate(-21%, -15%) scale(.82);
    }

    .rv-photo-stack-right .rv-photo-card[data-depth="4"] {
        transform: translate(-28%, -20%) scale(.76);
    }

    /* Photo pops in, glows, and settles */
    @keyframes rv-photo-arrive {
        0% {
            opacity: 0;
            transform: translateY(35px) scale(.84);
            filter: brightness(1.8);
        }

        60% {
            opacity: 1;
            filter: brightness(1.35);
            box-shadow:
                0 0 30px rgba(0, 220, 255, 1),
                0 0 65px rgba(0, 100, 255, .65);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: brightness(1);
        }
    }

    .rv-photo-card.rv-photo-enter {
        animation: rv-photo-arrive 1s cubic-bezier(.2, .8, .2, 1) both;
    }

    /* PAUSE THE ANIMATION WHEN ANOTHER SLIDE IS ACTIVE */
    .rv-slide:not(.active) .rv-photo-card {
        animation-play-state: paused;
    }

    @media (max-width: 760px) {
        .rv-latest-heading {
            top: 12%;
        }

        .rv-latest-heading h1 {
            font-size: 34px;
        }

        .rv-photo-stack {
            width: 46%;
            top: 43%;
        }

        .rv-photo-card {
            border-radius: 12px;
            border-width: 1px;
        }

        .rv-heading-line {
            margin-top: 10px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rv-photo-card {
            transition: none;
        }

        .rv-photo-card.rv-photo-enter {
            animation: none;
        }
    }
</style>
@endpush

@push('showcase-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slide = document.getElementById('latestCreationsSlide');

    if (!slide || slide.dataset.carouselReady === 'true') {
        return;
    }

    slide.dataset.carouselReady = 'true';

    const stacks = slide.querySelectorAll('[data-photo-stack]');
    const interval = 4000;
    let timer = null;

    function rotateStack(stack) {
        if (!slide.classList.contains('active')) {
            return;
        }

        const cards = Array.from(stack.children);

        if (cards.length < 2) {
            return;
        }

        // Send the current front card to the back.
        const frontCard = cards.shift();
        stack.appendChild(frontCard);

        // Reassign depth so the next card becomes the front card.
        Array.from(stack.children).forEach((card, index) => {
            card.dataset.depth = index;
            card.classList.remove('rv-photo-enter');
        });

        const newFront = stack.querySelector('[data-depth="0"]');

        if (newFront) {
            void newFront.offsetWidth;
            newFront.classList.add('rv-photo-enter');
        }
    }

    function startCarousel() {
        if (timer) {
            return;
        }

        timer = window.setInterval(function () {
            stacks.forEach(rotateStack);
        }, interval);
    }

    function stopCarousel() {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    }

    // Each stack holds half of the configured number of latest photos.
    const maxCardsPerStack = {{ (int) ceil(config('slideshow.latest_photos_limit') / 2) }};
    let nextStackIndex = 0;

    // A new photo from the booth (announced by the pop-up) lands at the front
    // of a stack, and the oldest card in that stack drops off.
    document.addEventListener('rv:new-photo', function (event) {
        // Fill the shorter stack first; when they are even, alternate sides.
        const stackList = Array.from(stacks);
        const fewestCards = Math.min(...stackList.map((stack) => stack.children.length));
        const candidates = stackList.filter((stack) => stack.children.length === fewestCards);
        const stack = candidates.includes(stackList[nextStackIndex]) ? stackList[nextStackIndex] : candidates[0];

        nextStackIndex = (stackList.indexOf(stack) + 1) % stackList.length;

        const card = document.createElement('div');
        const photo = document.createElement('img');
        const glow = document.createElement('div');

        card.className = 'rv-photo-card';
        photo.src = event.detail.url;
        photo.alt = 'Latest generated photo';
        photo.referrerPolicy = 'no-referrer';
        glow.className = 'rv-photo-glow';
        card.append(photo, glow);
        stack.prepend(card);

        while (stack.children.length > maxCardsPerStack) {
            stack.lastElementChild.remove();
        }

        Array.from(stack.children).forEach((stackCard, index) => {
            stackCard.dataset.depth = index;
            stackCard.classList.remove('rv-photo-enter');
        });

        void card.offsetWidth;
        card.classList.add('rv-photo-enter');

        slide.querySelector('.rv-latest-empty')?.remove();
    });

    // Start only when this slide is visible.
    const observer = new MutationObserver(function () {
        if (slide.classList.contains('active')) {
            startCarousel();
        } else {
            stopCarousel();
        }
    });

    observer.observe(slide, {
        attributes: true,
        attributeFilter: ['class']
    });

    if (slide.classList.contains('active')) {
        startCarousel();
    }
});
</script>
@endpush
