<?php
    /** @var \Tempest\Support\Arr\ImmutableArray $attributes */ 
    $attributes = $attributes->merge([
        'x' => 'woop',
    ]);
?><div data-raw="humph" ...$attributes><x-slot /></div>