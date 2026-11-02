<?php

namespace App\Services;

/**
 * Spreads any number of floating cards over a widescreen slide, keeping the
 * centre clear for the heading. Cards sit on a loose grid whose size grows
 * with the number of cards, each nudged and tilted a little so the result
 * looks scattered rather than tiled.
 */
class FloatingCardLayout
{
    /**
     * Width / height of the area the cards float in (a 16:9 screen minus
     * the slide padding), and of a 6:4 card's grid cell.
     */
    private const AREA_RATIO = 1.74;

    private const CELL_RATIO = 1.5;

    /**
     * Half the width / height (in %) of the centre area kept clear for the
     * heading, around its centre point.
     */
    private const HEADING_HALF_WIDTH = 18;

    private const HEADING_HALF_HEIGHT = 23;

    private const HEADING_CENTRE_Y = 48;

    /**
     * @return array{columns: int, rows: int, slots: list<array{x: float, y: float, rotate: int, scale: float, duration: float, delay: float}>}
     */
    public function arrange(int $cardCount): array
    {
        if ($cardCount < 1) {
            return ['columns' => 1, 'rows' => 1, 'slots' => []];
        }

        for ($rows = 2; ; $rows++) {
            $columns = max(2, (int) round($rows * self::AREA_RATIO / self::CELL_RATIO));
            $freeCells = $this->freeCells($columns, $rows);

            if (count($freeCells) >= $cardCount) {
                break;
            }
        }

        // Spread the cards evenly over the free cells, so any empty cells are
        // scattered rather than bunched at the end.
        $slots = [];

        for ($index = 0; $index < $cardCount; $index++) {
            $cell = $freeCells[intdiv($index * count($freeCells), $cardCount)];
            $slots[] = $this->slot($index, $cell, $columns, $rows);
        }

        return ['columns' => $columns, 'rows' => $rows, 'slots' => $slots];
    }

    /**
     * Grid cells, as [column, row], whose centre is outside the heading area.
     *
     * @return list<array{0: int, 1: int}>
     */
    private function freeCells(int $columns, int $rows): array
    {
        $cells = [];

        for ($row = 0; $row < $rows; $row++) {
            for ($column = 0; $column < $columns; $column++) {
                $x = ($column + .5) * 100 / $columns;
                $y = ($row + .5) * 100 / $rows;

                $isUnderHeading = abs($x - 50) < self::HEADING_HALF_WIDTH
                    && abs($y - self::HEADING_CENTRE_Y) < self::HEADING_HALF_HEIGHT;

                if (! $isUnderHeading) {
                    $cells[] = [$column, $row];
                }
            }
        }

        return $cells;
    }

    /**
     * The card's centre point (in % of the area) with a small, repeatable
     * nudge, tilt, size and float timing based on its position in the list.
     *
     * @param  array{0: int, 1: int}  $cell
     * @return array{x: float, y: float, rotate: int, scale: float, duration: float, delay: float}
     */
    private function slot(int $index, array $cell, int $columns, int $rows): array
    {
        [$column, $row] = $cell;
        $cellWidth = 100 / $columns;
        $cellHeight = 100 / $rows;

        return [
            'x' => round(($column + .5) * $cellWidth + ((($index * 7) % 5) - 2) * $cellWidth * .04, 2),
            'y' => round(($row + .5) * $cellHeight + ((($index * 3) % 5) - 2) * $cellHeight * .04, 2),
            'rotate' => (($index * 37) % 11) - 5,
            'scale' => round(.9 + (($index * 13) % 3) * .05, 2),
            'duration' => round(6 + (($index * 13) % 30) / 10, 1),
            'delay' => -round(($index * 7) % 60 / 10, 1),
        ];
    }
}
