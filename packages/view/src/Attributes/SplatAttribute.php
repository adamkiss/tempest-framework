<?php

declare(strict_types = 1);

namespace Tempest\View\Attributes;

use Tempest\View\Element;
use Tempest\View\Attribute;
use InvalidArgumentException;
use Tempest\View\ShouldBeRemoved;
use Illuminate\Support\Stringable;
use Tempest\Support\Arr\ArrayInterface;
use Tempest\View\Attributes\AttributeFactory;

final readonly class SplatAttribute implements Attribute {
	public function __construct(
		private string $name,
	) {}

	public function apply(Element $element): Element {
		$value = ltrim($this->name, '.');

		$element
			->addRawAttribute($this->compileAttribute($value))
			->unsetAttribute($this->name);

		return $element;
	}

	private function compileAttribute(string $value): string {
		return sprintf(
			"<?= %s::render(%s ?? null) ?>",
			self::class,
			$value,
		);
	}

	public static function render(mixed $value): string {
        if (! $value) {
			return '';
		}

        if (!is_array($value) && ! $value instanceof \Traversable) {
            throw new \InvalidArgumentException('Splat attribute value must be an array or Traversable.');
        }

        $attributes = [];
        foreach ($value as $k => $v) {
			if (str_starts_with($k, ':') || str_starts_with($k, '::')) {
				$k = ltrim($k, ':');
			}
			$v = static::resolveValue($v);
            $attributes []= sprintf('%s="%s"', $k, $v);
        }
		return implode(' ', $attributes);
	}

	public  static function resolveValue(mixed $value): string
    {
        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if ($value instanceof ArrayInterface) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
			$result = [];
            foreach ($value as $k => $v) {
				if (is_int($k)) {
					$result []= $v;
				} else if ($v === true) {
					$result []= $k;
				}
				$value = join(' ', $result);
			}
        }

        return (string) $value;
    }
}
