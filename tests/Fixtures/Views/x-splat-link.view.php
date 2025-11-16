<?php 
    /** @var \Tempest\Support\Arr\ImmutableArray $attributes */

    $attr = $attributes->merge([
        'class' => [
            $attributes->get('class'),
            'is-active' => true,
            'is-not-active' => false,
        ],
        'title' => $slots->get('default')->content,
    ]);

?><a ...$attr><x-slot /></a>
