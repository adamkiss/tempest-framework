<?php

declare(strict_types=1);

namespace Tempest\View\Attributes;

use Tempest\View\Attribute;
use Tempest\View\Element;

final readonly class SplatAttribute implements Attribute
{
    public function __construct(
        private string $name,
    ) {}

    public function apply(Element $element): Element
    {
        $value = str($element->getAttribute($this->name));

        

        ray($element);
        return $element;
    }
}
