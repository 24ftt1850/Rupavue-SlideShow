
@extends('layouts.showcase')

@section('content')

    <!-- SLIDE 1: RUPAVUE WELCOME -->
    <section class="rv-slide active" id="welcomeSlide">
        @include('showcase.slides.welcome')
    </section>

    <!-- SLIDE 2: HOW IT WORKS -->
    <section class="rv-slide" id="howSlide">
        @include('showcase.slides.how-it-works')
    </section>

    <!-- SLIDE 3: MULTIPLE AI THEMES -->
    <section class="rv-slide" id="themesSlide">
        @include('showcase.slides.themes')
    </section>

    <!-- SLIDE 4: LATEST GENERATED PHOTOS -->
    <section class="rv-slide" id="latestCreationsSlide">
        @include('showcase.slides.latest-creations')
    </section>

    @include('showcase.new-photo-popup')

@endsection

@push('showcase-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.rv-slide');

        // Each slide stays visible for 15 seconds.
        const slideDuration = 15000;

        let currentSlide = 0;

        function showNextSlide() {
            // Hold the current slide while a new photo is popped up.
            if (document.body.classList.contains('rv-popup-open')) {
                return;
            }

            slides[currentSlide].classList.remove('active');

            currentSlide = (currentSlide + 1) % slides.length;

            slides[currentSlide].classList.add('active');
        }

        // Automatically switch slides every 15 seconds.
        window.setInterval(showNextSlide, slideDuration);
    });
</script>
@endpush
