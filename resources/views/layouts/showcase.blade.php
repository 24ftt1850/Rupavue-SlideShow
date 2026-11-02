
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RUPAVUE | Smart Showcase</title>

    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --rv-navy: #020716;
            --rv-cyan: #48dce5;
            --rv-blue: #078cff;
            --rv-white: #f7fbff;
            --rv-muted: #b9c9df;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            overflow: hidden;
            background: var(--rv-navy);
            color: var(--rv-white);
            font-family: 'Inter', sans-serif;
        }

        /* Persistent galaxy background */
        .rv-background {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
            background:
                radial-gradient(
                    ellipse at 25% 40%,
                    rgba(0, 44, 130, .50),
                    transparent 47%
                ),
                radial-gradient(
                    ellipse at 80% 55%,
                    rgba(0, 22, 66, .45),
                    transparent 55%
                ),
                linear-gradient(
                    115deg,
                    #020715,
                    #03112e 55%,
                    #010511
                );
        }

        .rv-glow {
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: #005dff;
            filter: blur(85px);
            opacity: .52;
            animation: rv-float-glow 12s ease-in-out infinite alternate;
        }

        .rv-glow-top-left {
            top: -170px;
            left: -140px;
        }

        .rv-glow-top-right {
            top: -170px;
            right: -140px;
            animation-delay: -3s;
        }

        .rv-glow-bottom-left {
            bottom: -180px;
            left: -120px;
            animation-delay: -6s;
        }

        .rv-glow-bottom-right {
            bottom: -180px;
            right: -120px;
            animation-delay: -2s;
        }

        @keyframes rv-float-glow {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(35px, -25px);
            }
        }

        .rv-stars {
            position: absolute;
            inset: 0;
            opacity: .7;
            background-image:
                radial-gradient(
                    1px 1px at 12% 15%,
                    white 99%,
                    transparent
                ),
                radial-gradient(
                    2px 2px at 43% 24%,
                    #8beaff 99%,
                    transparent
                ),
                radial-gradient(
                    1px 1px at 87% 22%,
                    white 99%,
                    transparent
                ),
                radial-gradient(
                    1px 1px at 75% 75%,
                    white 99%,
                    transparent
                ),
                radial-gradient(
                    2px 2px at 22% 80%,
                    #69caff 99%,
                    transparent
                );
            background-size: 360px 360px;
            animation: rv-star-drift 45s linear infinite;
        }

        @keyframes rv-star-drift {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-360px);
            }
        }

        .rv-orbit {
            position: absolute;
            width: 240px;
            height: 240px;
            border: 1px solid rgba(0, 155, 255, .55);
            border-radius: 50%;
        }

        .rv-orbit-left {
            left: -170px;
            top: 20%;
        }

        .rv-orbit-right {
            right: -170px;
            bottom: 16%;
        }

        /* Content supplied by individual slides */
        .rv-showcase-content {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        /* Used by the slideshow container */
        .rv-slide {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4vh 5vw;

            opacity: 0;
            visibility: hidden;
            pointer-events: none;

            transform: scale(.99);
            transition:
                opacity 1s ease,
                transform 1s ease,
                visibility 1s;
        }

        .rv-slide.active {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        @media (max-width: 760px) {
            body {
                overflow: auto;
            }

            .rv-slide {
                align-items: flex-start;
                overflow-y: auto;
                padding: 30px 6vw;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rv-glow,
            .rv-stars {
                animation: none !important;
            }

            .rv-slide {
                transition: none;
            }
        }
    </style>

    @stack('showcase-styles')
</head>

<body>
    <!-- Background remains unchanged while slides change -->
    <div class="rv-background" aria-hidden="true">
        <div class="rv-glow rv-glow-top-left"></div>
        <div class="rv-glow rv-glow-top-right"></div>
        <div class="rv-glow rv-glow-bottom-left"></div>
        <div class="rv-glow rv-glow-bottom-right"></div>

        <div class="rv-stars"></div>

        <div class="rv-orbit rv-orbit-left"></div>
        <div class="rv-orbit rv-orbit-right"></div>
    </div>

    <main class="rv-showcase-content">
        @yield('content')
    </main>

    @stack('showcase-scripts')
</body>
</html>
