<!-- NEW PHOTO POP-UP: shown over any slide when the booth generates a photo -->
<div
    class="rv-new-photo"
    data-new-photo-popup
    data-photos-url="{{ route('showcase.photos') }}"
    data-check-seconds="{{ config('slideshow.new_photo_check_seconds') }}"
    data-show-seconds="{{ config('slideshow.new_photo_seconds') }}"
    style="--rv-new-photo-duration: {{ config('slideshow.new_photo_seconds') }}s;"
    role="status"
    aria-live="polite"
    aria-hidden="true"
>
    <div class="rv-new-photo-backdrop"></div>

    <div class="rv-new-photo-burst" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <figure class="rv-new-photo-card">
        <div class="rv-new-photo-badge">
            <span class="rv-new-photo-badge-dot"></span>
            JUST CREATED
        </div>

        <div class="rv-new-photo-frame">
            <img data-new-photo-image alt="Newly generated photo">
        </div>

        <figcaption class="rv-new-photo-caption">
            <span>FRESH FROM THE BOOTH</span>
            <h2>Your AI Portrait</h2>
        </figcaption>

        <div class="rv-new-photo-progress">
            <span></span>
        </div>
    </figure>
</div>

@push('showcase-styles')
<style>
    .rv-new-photo {
        position: fixed;
        inset: 0;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4vh 5vw;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition:
            opacity .6s ease,
            visibility .6s;
    }

    .rv-new-photo.is-visible {
        opacity: 1;
        visibility: visible;
    }

    .rv-new-photo-backdrop {
        position: absolute;
        inset: 0;
        background: radial-gradient(
            ellipse at center,
            rgba(3, 17, 46, .7),
            rgba(2, 7, 22, .92) 70%
        );
        backdrop-filter: blur(10px);
    }

    /* Rings that burst out from behind the photo as it arrives */
    .rv-new-photo-burst {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
    }

    .rv-new-photo-burst span {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40vh;
        height: 40vh;
        border: 2px solid rgba(72, 220, 229, .8);
        border-radius: 50%;
        box-shadow: 0 0 30px rgba(0, 140, 255, .6);
        opacity: 0;
        transform: translate(-50%, -50%) scale(.2);
    }

    .rv-new-photo.is-visible .rv-new-photo-burst span {
        animation: rv-new-photo-burst 1.6s cubic-bezier(.2, .8, .2, 1) both;
    }

    .rv-new-photo.is-visible .rv-new-photo-burst span:nth-child(2) {
        animation-delay: .2s;
    }

    .rv-new-photo.is-visible .rv-new-photo-burst span:nth-child(3) {
        animation-delay: .4s;
    }

    @keyframes rv-new-photo-burst {
        0% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(.2);
        }
        20% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(3);
        }
    }

    .rv-new-photo-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        transform: scale(.6) rotate(-4deg);
        opacity: 0;
    }

    .rv-new-photo.is-visible .rv-new-photo-card {
        animation: rv-new-photo-pop .9s cubic-bezier(.2, 1.3, .3, 1) .1s both;
    }

    @keyframes rv-new-photo-pop {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(.6) rotate(-4deg);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotate(0);
        }
    }

    .rv-new-photo-badge {
        position: absolute;
        z-index: 2;
        top: -18px;
        left: 50%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 20px;
        border: 1.5px solid #48dce5;
        border-radius: 999px;
        background: #061a40;
        color: #f7fbff;
        font-size: clamp(11px, .9vw, 15px);
        font-weight: 900;
        letter-spacing: 3px;
        white-space: nowrap;
        box-shadow: 0 0 22px rgba(72, 220, 229, .55);
        transform: translateX(-50%);
    }

    .rv-new-photo-badge-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #48dce5;
        box-shadow: 0 0 10px #48dce5;
        animation: rv-new-photo-blink 1.1s ease-in-out infinite;
    }

    @keyframes rv-new-photo-blink {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .35; transform: scale(.7); }
    }

    .rv-new-photo-frame {
        padding: 4px;
        border: 1px solid rgba(72, 192, 255, .85);
        border-radius: 24px;
        background: linear-gradient(
            135deg,
            #178dff,
            #071329,
            #48dce5
        );
        box-shadow:
            0 0 30px rgba(0, 190, 255, .6),
            0 0 90px rgba(0, 100, 255, .35);
    }

    .rv-new-photo-frame img {
        display: block;
        max-width: min(80vw, 1100px);
        max-height: 66vh;
        border-radius: 20px;
        background: #071329;
        object-fit: contain;
    }

    .rv-new-photo-caption {
        margin-top: 22px;
        text-align: center;
    }

    .rv-new-photo-caption span {
        color: #48dce5;
        font-size: clamp(10px, .8vw, 13px);
        font-weight: 800;
        letter-spacing: 4px;
    }

    .rv-new-photo-caption h2 {
        margin-top: 6px;
        color: #f7fbff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(26px, 2.6vw, 44px);
        font-weight: 700;
        line-height: 1.1;
        text-shadow: 0 0 22px rgba(0, 140, 255, .35);
    }

    /* Countdown until the pop-up closes */
    .rv-new-photo-progress {
        width: min(260px, 50vw);
        height: 3px;
        margin-top: 18px;
        overflow: hidden;
        border-radius: 3px;
        background: rgba(72, 220, 229, .18);
    }

    .rv-new-photo-progress span {
        display: block;
        width: 100%;
        height: 100%;
        background: #48dce5;
        box-shadow: 0 0 10px #48dce5;
        transform-origin: left;
    }

    .rv-new-photo.is-visible .rv-new-photo-progress span {
        animation: rv-new-photo-countdown var(--rv-new-photo-duration) linear both;
    }

    @keyframes rv-new-photo-countdown {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .rv-new-photo.is-visible .rv-new-photo-card,
        .rv-new-photo.is-visible .rv-new-photo-burst span,
        .rv-new-photo-badge-dot {
            animation: none;
        }

        .rv-new-photo.is-visible .rv-new-photo-card {
            opacity: 1;
            transform: none;
        }
    }
</style>
@endpush

@push('showcase-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.querySelector('[data-new-photo-popup]');

    if (!popup) {
        return;
    }

    const image = popup.querySelector('[data-new-photo-image]');
    const checkInterval = Number(popup.dataset.checkSeconds) * 1000;
    const showDuration = Number(popup.dataset.showSeconds) * 1000;

    // Photos already in the booth when the page loaded are not "new".
    let seenPhotoIds = null;
    const queue = [];
    let isShowing = false;

    async function checkForNewPhotos() {
        let photos;

        try {
            const response = await fetch(popup.dataset.photosUrl, {
                headers: { Accept: 'application/json' },
            });

            if (!response.ok) {
                return;
            }

            photos = (await response.json()).photos;
        } catch (error) {
            return;
        }

        if (seenPhotoIds === null) {
            seenPhotoIds = new Set(photos.map((photo) => photo.id));

            return;
        }

        // The list is newest first; reverse it so several new photos pop up
        // in the order they were made.
        photos
            .filter((photo) => photo.url && !seenPhotoIds.has(photo.id))
            .reverse()
            .forEach((photo) => {
                seenPhotoIds.add(photo.id);
                queue.push(photo);
            });

        showNextPhoto();
    }

    function showNextPhoto() {
        if (isShowing || queue.length === 0) {
            return;
        }

        const photo = queue.shift();
        const preload = new Image();

        isShowing = true;

        // Only pop up once the photo has loaded; skip any that fail.
        preload.onload = function () {
            openPopup(photo);
        };

        preload.onerror = function () {
            isShowing = false;
            showNextPhoto();
        };

        preload.src = photo.url;
    }

    function openPopup(photo) {
        image.src = photo.url;

        // Pauses the slide rotation in showcase/index.blade.php.
        document.body.classList.add('rv-popup-open');
        popup.setAttribute('aria-hidden', 'false');
        popup.classList.add('is-visible');

        window.setTimeout(function () {
            closePopup(photo);
        }, showDuration);
    }

    function closePopup(photo) {
        popup.classList.remove('is-visible');
        popup.setAttribute('aria-hidden', 'true');

        // The "Latest Generated" slide adds the photo to its stacks.
        document.dispatchEvent(new CustomEvent('rv:new-photo', { detail: photo }));

        // Wait for the fade-out before showing the next photo.
        window.setTimeout(function () {
            document.body.classList.remove('rv-popup-open');
            isShowing = false;
            showNextPhoto();
        }, 700);
    }

    checkForNewPhotos();
    window.setInterval(checkForNewPhotos, checkInterval);
});
</script>
@endpush
