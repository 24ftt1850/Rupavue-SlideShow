/**
 * Kiosk slideshow: rotates description slides and the booth's latest photos.
 * Photos come from the Livewire component's polled `photos` property; any
 * photo that appears after the page loaded jumps the queue as "Just created".
 */
const PHOTOS_PER_DESCRIPTION = 4;
const CURSOR_IDLE_MS = 3000;

document.addEventListener('alpine:init', () => {
    window.Alpine.data('slideshow', ({ descriptions, themeNames, slideSeconds }) => ({
        deck: [],
        current: 0,
        direction: 1,
        progress: 0,
        slideStartedAt: Date.now(),
        seenPhotoIds: null,
        freshPhotoIds: [],
        freshShowingId: null,
        brokenPhotoIds: new Set(),
        themeNames,
        cursorHidden: false,
        isFullscreen: false,

        init() {
            this.rebuildDeck();
            this.$wire.$watch('photos', () => this.rebuildDeck());

            setInterval(() => this.tick(), 100);
            this.wakeCursor();

            document.addEventListener('fullscreenchange', () => {
                this.isFullscreen = Boolean(document.fullscreenElement);
            });
        },

        infoSlides() {
            const slides = descriptions.map((description, index) => ({
                type: 'description',
                key: `description-${index}`,
                ...description,
            }));

            if (this.themeNames.length) {
                slides.push({ type: 'themes', key: 'themes' });
            }

            return slides;
        },

        rebuildDeck() {
            const photos = this.$wire.photos.filter((photo) => photo.url && !this.brokenPhotoIds.has(photo.id));

            this.trackFreshPhotos(photos);

            const currentKey = this.deck[this.current]?.key;
            const info = this.infoSlides();
            const deck = [];

            if (!photos.length) {
                deck.push(...info, { type: 'empty', key: 'empty' });
            } else {
                let infoShown = 0;

                for (let start = 0; start < photos.length; start += PHOTOS_PER_DESCRIPTION) {
                    if (info.length) {
                        const slide = info[infoShown % info.length];
                        deck.push({ ...slide, key: `${slide.key}-${infoShown}` });
                        infoShown++;
                    }

                    photos.slice(start, start + PHOTOS_PER_DESCRIPTION).forEach((photo) => {
                        deck.push({ type: 'photo', key: `photo-${photo.id}`, photo });
                    });
                }

                // With only a few photos, still show every description once.
                for (; infoShown < info.length; infoShown++) {
                    deck.push({ ...info[infoShown], key: `${info[infoShown].key}-${infoShown}` });
                }
            }

            this.deck = deck;

            const keptIndex = deck.findIndex((slide) => slide.key === currentKey);
            this.current = keptIndex >= 0 ? keptIndex : 0;
        },

        trackFreshPhotos(photos) {
            const ids = photos.map((photo) => photo.id);

            // Photos already there on first load are not "new".
            if (this.seenPhotoIds === null) {
                this.seenPhotoIds = new Set(ids);

                return;
            }

            ids.filter((id) => !this.seenPhotoIds.has(id))
                .reverse()
                .forEach((id) => {
                    this.seenPhotoIds.add(id);
                    this.freshPhotoIds.push(id);
                });
        },

        tick() {
            const elapsed = Date.now() - this.slideStartedAt;
            this.progress = Math.min(100, (elapsed / (slideSeconds * 1000)) * 100);

            if (elapsed >= slideSeconds * 1000) {
                this.next();
            }
        },

        showSlide(index, direction = 1) {
            this.direction = direction;
            this.current = index;
            this.slideStartedAt = Date.now();
            this.progress = 0;
        },

        next() {
            while (this.freshPhotoIds.length) {
                const id = this.freshPhotoIds.shift();
                const index = this.deck.findIndex((slide) => slide.key === `photo-${id}`);

                if (index >= 0) {
                    this.freshShowingId = id;
                    this.showSlide(index);

                    return;
                }
            }

            this.freshShowingId = null;
            this.showSlide((this.current + 1) % this.deck.length);
        },

        previous() {
            this.freshShowingId = null;
            this.showSlide((this.current - 1 + this.deck.length) % this.deck.length, -1);
        },

        /** A photo whose file is gone from the booth is dropped from the deck. */
        skipBrokenPhoto(photo) {
            this.brokenPhotoIds.add(photo.id);
            this.rebuildDeck();
        },

        wakeCursor() {
            this.cursorHidden = false;
            clearTimeout(this.cursorTimer);
            this.cursorTimer = setTimeout(() => (this.cursorHidden = true), CURSOR_IDLE_MS);
        },

        toggleFullscreen() {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        },
    }));
});
