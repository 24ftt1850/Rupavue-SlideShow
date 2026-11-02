<?php

use App\Services\FloatingCardLayout;

test('every card gets its own slot clear of the heading', function (int $cardCount) {
    $layout = (new FloatingCardLayout)->arrange($cardCount);
    $cellWidth = 100 / $layout['columns'];
    $cellHeight = 100 / $layout['rows'];

    $cells = array_map(fn (array $slot): string => floor($slot['x'] / $cellWidth).':'.floor($slot['y'] / $cellHeight), $layout['slots']);

    expect($layout['slots'])->toHaveCount($cardCount)
        ->and(array_unique($cells))->toHaveCount($cardCount);

    foreach ($layout['slots'] as $slot) {
        expect(abs($slot['x'] - 50) < 18 && abs($slot['y'] - 48) < 23)->toBeFalse();
    }
})->with([1, 6, 23, 60]);

test('the grid grows as the folder fills up', function () {
    $layout = new FloatingCardLayout;

    expect($layout->arrange(60)['rows'])->toBeGreaterThan($layout->arrange(6)['rows']);
});

test('an empty folder has no slots', function () {
    expect((new FloatingCardLayout)->arrange(0)['slots'])->toBeEmpty();
});
