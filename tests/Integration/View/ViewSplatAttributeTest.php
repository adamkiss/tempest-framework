<?php

declare(strict_types=1);

namespace Tests\Tempest\Integration\View;

use Tempest\Http\Status;
use Tests\Tempest\Fixtures\Controllers\TestController;
use Tests\Tempest\Fixtures\Views\ViewModel;
use Tests\Tempest\Integration\FrameworkIntegrationTestCase;

use function Tempest\Router\uri;
use function Tempest\view;

/**
 * @internal
 */
final class ViewSplatAttributeTest extends FrameworkIntegrationTestCase
{
    public function test_render(): void
    {
        $view = view(__DIR__ . '/../../Fixtures/Views/splat-parent.view.php')->data(id: 'my-id', );

        $html = $this->render($view);
        ray($html);
        $x = fn () => ray(get_func_args());
        $arr = ['id' => 'test1', 'data-info' => 'extra'];
        $fn(...$arr, one: 'one', two: 'two');

        $this->assertStringContainsString(
            'id="test1"',
            $html,
        );

        $this->assertStringContainsString(
            'id="test2"',
            $html,
        );
    }
}
