<?php

use App\Models\GeneratedImage;
use App\Models\PhotoshootTheme;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::slideshow')] #[Title('Slideshow')] class extends Component
{
    /**
     * @var list<array{id: int, url: string, theme: string|null, created_ago: string|null}>
     */
    public array $photos = [];

    /**
     * @var list<string>
     */
    public array $themeNames = [];

    public function mount(): void
    {
        $this->loadPhotos();

        try {
            $this->themeNames = PhotoshootTheme::query()
                ->where('is_active', true)
                ->orderBy('theme_name')
                ->pluck('theme_name')
                ->all();
        } catch (QueryException $exception) {
            report($exception);
        }
    }

    /**
     * Polled by the screen. If the booth database is unreachable the last
     * known photos stay up instead of the kiosk showing an error page.
     */
    public function loadPhotos(): void
    {
        try {
            $this->photos = GeneratedImage::query()
                ->showable()
                ->with('theme:id,theme_name')
                ->latest('id')
                ->limit(config('slideshow.photo_limit'))
                ->get()
                ->map(fn (GeneratedImage $photo): array => [
                    'id' => $photo->id,
                    'url' => $photo->photo_url,
                    'theme' => $photo->theme?->theme_name,
                    'created_ago' => $photo->created_at?->diffForHumans(),
                ])
                ->all();
        } catch (QueryException $exception) {
            report($exception);
        }
    }
}; ?>

<div wire:poll.{{ config('slideshow.refresh_seconds') }}s="loadPhotos" class="h-full">
    <div
        wire:ignore
        x-data="slideshow({
            descriptions: @js(config('slideshow.description_slides')),
            themeNames: @js($themeNames),
            slideSeconds: @js(config('slideshow.slide_seconds')),
        })"
        x-on:keydown.window.f="toggleFullscreen()"
        x-on:keydown.window.arrow-right="next()"
        x-on:keydown.window.arrow-left="previous()"
        x-on:mousemove.window="wakeCursor()"
        x-bind:class="cursorHidden && 'cursor-none'"
        x-bind:style="`--slide-direction: ${direction}`"
        class="relative h-full w-full overflow-hidden"
    >
        <template x-for="(slide, index) in deck" x-bind:key="slide.key">
            <section
                x-show="index === current"
                x-transition:enter="transition duration-1000 ease-in-out"
                x-transition:enter-start="translate-x-[calc(var(--slide-direction)*100%)]"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition duration-1000 ease-in-out"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-[calc(var(--slide-direction)*-100%)]"
                class="absolute inset-0"
            >
                {{-- Photo slide --}}
                <template x-if="slide.type === 'photo'">
                    <div class="relative flex h-full w-full items-center justify-center">
                        <img x-bind:src="slide.photo.url" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full scale-110 object-cover opacity-40 blur-3xl">
                        <div class="absolute inset-0 bg-linear-to-t from-[#0A1628] via-[#0A1628]/20 to-[#0A1628]/60"></div>

                        <img
                            x-bind:src="slide.photo.url"
                            x-on:error="skipBrokenPhoto(slide.photo)"
                            x-bind:alt="slide.photo.theme ? `RupaVue ${slide.photo.theme} portrait` : 'RupaVue portrait'"
                            class="relative max-h-[78svh] max-w-[90vw] rounded-2xl object-contain shadow-2xl shadow-black/60 ring-1 ring-white/10"
                        >

                        <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-6 px-[5vw] pb-[5svh]">
                            <div class="flex flex-col gap-2">
                                <span
                                    x-show="freshShowingId === slide.photo.id"
                                    class="w-fit animate-pulse rounded-full bg-[#3B82F6] px-4 py-1 text-sm font-semibold tracking-wide uppercase"
                                >Just created</span>
                                <p class="text-[clamp(1.5rem,3vw,3rem)] leading-tight font-bold" x-text="slide.photo.theme ?? 'RupaVue Original'"></p>
                                <p class="text-[clamp(0.9rem,1.4vw,1.25rem)] text-[#8FA3BF]" x-text="slide.photo.created_ago ? `Created ${slide.photo.created_ago}` : ''"></p>
                            </div>
                            <p class="text-right text-[clamp(0.9rem,1.4vw,1.25rem)] text-[#8FA3BF]">Your photo could be next.<br><span class="text-[#FAFAFA]">Visit the booth.</span></p>
                        </div>
                    </div>
                </template>

                {{-- Description slide --}}
                <template x-if="slide.type === 'description'">
                    <div class="flex h-full w-full items-center bg-[radial-gradient(ellipse_at_top_left,#3B82F640,transparent_55%)] px-[8vw]">
                        <div class="flex max-w-5xl flex-col gap-[3svh]">
                            <p class="text-[clamp(0.9rem,1.5vw,1.4rem)] font-semibold tracking-[0.35em] text-[#3B82F6] uppercase" x-text="slide.eyebrow"></p>
                            <h1 class="text-[clamp(2.25rem,6vw,6rem)] leading-[1.05] font-bold text-balance" x-text="slide.title"></h1>
                            <p x-show="slide.body" class="max-w-3xl text-[clamp(1.1rem,2vw,2rem)] text-pretty text-[#B8C7DD]" x-text="slide.body"></p>

                            <ol x-show="slide.steps.length" class="flex flex-col gap-[1.6svh]">
                                <template x-for="(step, stepIndex) in slide.steps" x-bind:key="stepIndex">
                                    <li class="flex items-center gap-5 text-[clamp(1.1rem,2.2vw,2.2rem)]">
                                        <span class="flex size-[clamp(2.25rem,3.5vw,3.5rem)] shrink-0 items-center justify-center rounded-full bg-[#3B82F6] font-bold" x-text="stepIndex + 1"></span>
                                        <span x-text="step"></span>
                                    </li>
                                </template>
                            </ol>
                        </div>
                    </div>
                </template>

                {{-- Themes slide --}}
                <template x-if="slide.type === 'themes'">
                    <div class="flex h-full w-full items-center bg-[radial-gradient(ellipse_at_bottom_right,#3B82F640,transparent_55%)] px-[8vw]">
                        <div class="flex flex-col gap-[4svh]">
                            <p class="text-[clamp(0.9rem,1.5vw,1.4rem)] font-semibold tracking-[0.35em] text-[#3B82F6] uppercase">Choose your scene</p>
                            <h1 class="text-[clamp(2.25rem,6vw,6rem)] leading-[1.05] font-bold">Where will you go today?</h1>
                            <ul class="flex max-w-6xl flex-wrap gap-4">
                                <template x-for="name in themeNames" x-bind:key="name">
                                    <li class="rounded-full border border-white/15 bg-white/5 px-6 py-3 text-[clamp(1rem,1.8vw,1.75rem)]" x-text="name"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </template>

                {{-- Shown while the booth has no photos yet --}}
                <template x-if="slide.type === 'empty'">
                    <div class="flex h-full w-full flex-col items-center justify-center gap-6 px-[8vw] text-center">
                        <p class="text-[clamp(0.9rem,1.5vw,1.4rem)] font-semibold tracking-[0.35em] text-[#3B82F6] uppercase">Gallery</p>
                        <h1 class="text-[clamp(2.25rem,6vw,6rem)] leading-[1.05] font-bold">The first portrait could be yours.</h1>
                        <p class="text-[clamp(1.1rem,2vw,2rem)] text-[#B8C7DD]">New photos from the booth will appear here automatically.</p>
                    </div>
                </template>
            </section>
        </template>

        {{-- Brand mark --}}
        <p class="pointer-events-none absolute top-[4svh] left-[5vw] text-[clamp(0.8rem,1.2vw,1.1rem)] font-semibold tracking-[0.35em] text-[#FAFAFA]/80">RUPAVUE</p>

        {{-- Fullscreen toggle, fades away with the cursor --}}
        <button
            type="button"
            x-on:click="toggleFullscreen()"
            x-show="!cursorHidden"
            x-transition.opacity
            class="absolute top-[3svh] right-[4vw] rounded-full bg-white/10 px-4 py-2 text-sm text-[#FAFAFA]/80 hover:bg-white/20"
            x-text="isFullscreen ? 'Exit fullscreen (F)' : 'Fullscreen (F)'"
        ></button>

        {{-- Progress of the current slide --}}
        <div class="absolute inset-x-0 bottom-0 h-1 bg-white/5">
            <div
                class="h-full bg-[#3B82F6]"
                x-bind:style="`width: ${progress}%`"
            ></div>
        </div>
    </div>
</div>
