
<div class="rv-welcome">
    <section class="rv-welcome-intro">

        <!-- Your RUPAVUE mascot -->
        <img
            class="rv-mascot"
            src="{{ asset('images/rupavue-mascot.png') }}"
            alt="RUPAVUE robot mascot"
        >

        <!-- Brand -->
        <h1 class="rv-brand">
            Rupa<span>Vue</span>
        </h1>

        <p class="rv-brand-caption">AI PHOTOBOOTH</p>

        <div class="rv-divider"></div>

        <!-- Tagline -->
        <h2 class="rv-tagline">
            YOUR MOMENT.<br>
            <span>REIMAGINED.</span>
        </h2>

        <!-- Project information -->
        <p class="rv-description">
            Transform ordinary photographs into extraordinary
            AI-generated portraits. Discover creative scenes,
            unique styles and customisable themes through the
            power of artificial intelligence.
        </p>

        <p class="rv-project-label">
            <span>RUPAVUE</span> · AI PHOTO EXPERIENCE
        </p>

    </section>

    <!-- Sample video -->
    <section class="rv-video-section">

        <div class="rv-video-heading">
            <h2>Discover <span>RUPAVUE</span></h2>
            <span class="rv-video-status">PROJECT PREVIEW</span>
        </div>

        <div class="rv-video-frame">
            <video
                class="rv-sample-video"
                autoplay
                muted
                loop
                playsinline
                preload="auto"
            >
                <source
                    src="{{ asset('videos/sample-video.mp4') }}"
                    type="video/mp4"
                >
            </video>
        </div>

        <div class="rv-video-caption">
            <span>AI-powered photography</span>
            <span>Creativity without limits</span>
        </div>

    </section>
</div>

@push('showcase-styles')
<style>
    .rv-welcome {
        width: 100%;
        max-width: 1600px;
        display: grid;
        grid-template-columns: 1fr 1.05fr;
        align-items: center;
        gap: 5vw;
    }

    .rv-welcome-intro {
        min-width: 0;
        text-align: center;
        animation: rv-welcome-appear 1.2s ease both;
    }

    @keyframes rv-welcome-appear {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .rv-mascot {
        display: block;
        width: clamp(90px, 10vw, 145px);
        height: clamp(80px, 9vw, 125px);
        object-fit: contain;
        margin: 0 auto 10px;
        filter: drop-shadow(0 0 16px rgba(0, 157, 255, .65));
        animation: rv-mascot-float 4s ease-in-out infinite;
    }

    @keyframes rv-mascot-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-7px); }
    }

    .rv-brand {
        font-family: 'Anton', sans-serif;
        font-size: clamp(55px, 7vw, 105px);
        font-weight: 400;
        line-height: 1;
        letter-spacing: -1.5px;
        white-space: nowrap;
    }

    .rv-brand span {
        color: var(--rv-cyan);
    }

    .rv-brand-caption {
        margin-top: 13px;
        color: var(--rv-cyan);
        font-size: clamp(10px, 1vw, 14px);
        font-weight: 700;
        letter-spacing: 6px;
    }

    .rv-divider {
        width: 60px;
        height: 3px;
        margin: 30px auto;
        border-radius: 5px;
        background: var(--rv-cyan);
        box-shadow: 0 0 14px var(--rv-cyan);
    }

    .rv-tagline {
        font-size: clamp(19px, 2vw, 31px);
        font-weight: 900;
        line-height: 1.5;
        letter-spacing: clamp(2px, .35vw, 5px);
    }

    .rv-tagline span {
        color: var(--rv-cyan);
    }

    .rv-description {
        max-width: 480px;
        margin: 20px auto 0;
        color: var(--rv-muted);
        font-size: clamp(12px, 1.1vw, 16px);
        line-height: 1.9;
    }

    .rv-project-label {
        margin-top: 24px;
        color: #8ca9ce;
        font-size: 10px;
        letter-spacing: 2.5px;
    }

    .rv-project-label span {
        color: var(--rv-cyan);
    }

    /* Width follows viewport height so the 4:3 frame never overflows */
    .rv-video-section {
        min-width: 0;
        width: min(100%, calc(66vh * 4 / 3));
        justify-self: center;
        animation: rv-video-appear 1.4s ease both;
    }

    @keyframes rv-video-appear {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .rv-video-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        font-size: clamp(11px, 1.1vw, 15px);
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .rv-video-heading h2 span {
        color: var(--rv-cyan);
    }

    .rv-video-status {
        color: #9cb6d4;
        font-size: 9px;
        letter-spacing: 1.2px;
        white-space: nowrap;
    }

    .rv-video-frame {
        width: 100%;
        aspect-ratio: 4 / 3;
        padding: 3px;
        overflow: hidden;
        border: 1px solid rgba(72, 192, 255, .75);
        border-radius: 20px;
        background: linear-gradient(
            135deg,
            #178dff,
            #071329,
            #48dce5
        );
        box-shadow: 0 0 35px rgba(0, 130, 255, .2);
    }

    .rv-sample-video {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 16px;
        background: #071329;
    }

    .rv-video-caption {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 14px;
        color: #9cb6d4;
        font-size: 9px;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .rv-video-caption span:last-child {
        color: var(--rv-cyan);
        text-align: right;
    }

    @media (max-width: 760px) {
        .rv-welcome {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .rv-brand {
            font-size: clamp(54px, 15vw, 80px);
        }

        .rv-divider {
            margin: 22px auto;
        }

        .rv-video-section {
            width: 100%;
        }

        .rv-video-frame {
            aspect-ratio: 16 / 10;
            border-radius: 15px;
        }
    }
</style>
@endpush
