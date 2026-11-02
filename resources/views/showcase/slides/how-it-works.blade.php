
<div class="rv-how">
    <h1 class="rv-how-title">
        HOW IT <span>WORKS</span>
    </h1>

    <div class="rv-steps">

        <!-- STEP 1 -->
        <article class="rv-step rv-step-1">
            <div class="rv-step-image">
                <span class="rv-step-number">01</span>
                <img
                    src="{{ asset('images/how-it-works/press-start.png') }}"
                    alt="Press start"
                >
            </div>
            <h2>PRESS <span>START</span></h2>
            <p>Begin your RUPAVUE experience.</p>
        </article>

        <!-- STEP 2 -->
        <article class="rv-step rv-step-2">
            <div class="rv-step-image">
                <span class="rv-step-number">02</span>
                <img
                    src="{{ asset('images/how-it-works/choose-theme.png') }}"
                    alt="Choose theme and frame"
                >
            </div>
            <h2>CHOOSE <span>THEME & FRAME</span></h2>
            <p>Pick your favourite AI theme and photo frame.</p>
        </article>

        <!-- STEP 3 -->
        <article class="rv-step rv-step-3">
            <div class="rv-step-image">
                <span class="rv-step-number">03</span>
                <img
                    src="{{ asset('images/how-it-works/take-picture.png') }}"
                    alt="Take a picture"
                >
            </div>
            <h2>TAKE A <span>PICTURE</span></h2>
            <p>Capture your best moment.</p>
        </article>

        <!-- STEP 4 -->
        <article class="rv-step rv-step-4">
            <div class="rv-step-image">
                <span class="rv-step-number">04</span>
                <img
                    src="{{ asset('images/how-it-works/ai-generate.png') }}"
                    alt="AI generated portrait"
                >
            </div>
            <h2>AI <span>GENERATE</span></h2>
            <p>Let AI transform your photo into a unique portrait.</p>
        </article>

        <!-- STEP 5 -->
        <article class="rv-step rv-step-5">
            <div class="rv-step-image">
                <span class="rv-step-number">05</span>
                <img
                    src="{{ asset('images/how-it-works/scan-print.png') }}"
                    alt="Scan QR code and print"
                >
            </div>
            <h2>SCAN & <span>PRINT</span></h2>
            <p>Scan the QR code and receive your printed photo.</p>
        </article>

    </div>
</div>

@push('showcase-styles')
<style>
    .rv-how {
        width: 100%;
        max-width: 1600px;
        margin: auto;
        text-align: center;
    }

    .rv-how-title {
        margin-bottom: clamp(28px, 5vh, 55px);
        font-family: 'Anton', sans-serif;
        font-size: clamp(42px, 5.2vw, 76px);
        font-weight: 400;
        letter-spacing: 3px;
        line-height: 1.1;
        text-shadow: 0 0 22px rgba(0, 130, 255, .4);
    }

    .rv-how-title span {
        color: var(--rv-cyan);
    }

    .rv-steps {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        column-gap: 2.2%;
        row-gap: 3.5vh;
        align-items: start;
    }

    .rv-step {
        position: relative;
        min-width: 0;
        grid-column: span 2;
        width: 100%;
        max-width: 320px;
        justify-self: center;
        animation: rv-step-appear .7s ease both;
    }

    .rv-step-1 { animation-delay: .1s; }
    .rv-step-2 { animation-delay: .2s; }
    .rv-step-3 { animation-delay: .3s; }

    .rv-step-4 {
        grid-column: 2 / span 2;
        animation-delay: .4s;
    }

    .rv-step-5 {
        grid-column: 4 / span 2;
        animation-delay: .5s;
    }

    @keyframes rv-step-appear {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .rv-step-image {
        position: relative;
        width: 100%;
        aspect-ratio: 1.08 / 1;
        padding: 3px;
        border: 1px solid rgba(51, 190, 255, .9);
        border-radius: 18px;
        background: linear-gradient(
            140deg,
            rgba(17, 111, 255, .4),
            rgba(3, 13, 36, .95),
            rgba(0, 218, 255, .18)
        );
        box-shadow:
            0 0 18px rgba(0, 126, 255, .2),
            inset 0 0 22px rgba(0, 140, 255, .1);
    }

    .rv-step-image img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 14px;
        background: rgba(4, 17, 41, .8);
    }

    .rv-step-number {
        position: absolute;
        z-index: 2;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border: 2px solid #19c9ff;
        border-radius: 50%;
        background: #061a40;
        color: white;
        font-size: 18px;
        font-weight: 900;
        box-shadow: 0 0 17px rgba(0, 151, 255, .65);
    }

    .rv-step h2 {
        margin-top: 14px;
        font-size: clamp(11px, 1.25vw, 18px);
        line-height: 1.4;
        font-weight: 900;
    }

    .rv-step h2 span {
        color: var(--rv-cyan);
    }

    .rv-step p {
        max-width: 290px;
        margin: 7px auto 0;
        color: #a8d5ff;
        font-size: clamp(10px, .9vw, 13px);
        line-height: 1.5;
    }

    @media (max-width: 760px) {
        .rv-how-title {
            margin-bottom: 35px;
        }

        .rv-steps {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 35px 20px;
        }

        .rv-step,
        .rv-step-4,
        .rv-step-5 {
            grid-column: auto;
        }

        .rv-step:last-child {
            grid-column: 1 / -1;
        }
    }
</style>
@endpush
