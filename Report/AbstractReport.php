<?php

declare(strict_types=1);

namespace Simples\Report;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Php\JSON;
use Simples\Report\Fragments\Getter;
use Simples\Report\Fragments\Where;

/**
 * Class AbstractReport
 *
 * @package Report
 */
abstract class AbstractReport
{
    /**
     */
    use Getter;
    use Where;

    /**
     * @var string
     */
    protected string $layout = 'portrait';

    /**
     * @var bool
     */
    protected bool $printing = false;

    /**
     * @var array
     */
    private array $info;

    /**
     * AbstractReport constructor.
     *
     * @param string $user
     * @param bool $printing
     */
    public function __construct(string $user, bool $printing = false)
    {
        $this->user = $user;
        $this->printing = $printing;
    }

    /**
     * @param string $user
     * @param bool $printing
     *
     * @return static
     */
    public static function build(string $user, bool $printing = false)
    {
        return new static($user, $printing);
    }

    /**
     * @param array $filters
     *
     * @return string
     * @throws Exception
     */
    final public function execute(array $filters): string
    {
        return $this->run($filters);
    }

    /**
     * @param array $filters
     *
     * @return string
     */
    private function run(array $filters): string
    {
        $this->filters = $filters;
        $this->info = [];
        if (isset($filters['__@info'])) {
            $map = static function ($info) {
                return JSON::decode($info, false);
            };
            $decoded = array_map($map, $filters['__@info']);
            $this->info = array_filter(
                $decoded,
                static function ($info) {
                    return isset($info->value);
                }
            );
            unset($filters['__@info']);
        }
        $callback = static function ($info) {
            if (is_scalar($info)) {
                return (string)$info !== '';
            }
            return (bool)($info->value ?? false);
        };
        $filters = array_filter($filters, $callback);
        $this->collection = $this->fetch($filters);

        return $this->render($this->template());
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    protected function fetch(array $filters): array
    {
        return DB::select((string)DB::raw($this->instruction($filters)), $filters);
    }

    /**
     * @param array $filters
     *
     * @return string
     */
    abstract protected function instruction(array &$filters): string;

    /**
     * @param string $template
     * @param array $parameters
     *
     * @return false|Factory|View|string
     */
    final protected function render(string $template, array $parameters = [])
    {
        require __DIR__ . '/../../../helper/report.php';

        $base = [
            'layout' => $this->layout,
            'printing' => $this->printing,
            'title' => $this->title,
            'collection' => $this->collection,
            'info' => $this->info,
            'user' => $this->user,
        ];
        $data = array_merge($base, $parameters);
        return view($template, $data);
    }

    /**
     * @return string
     */
    abstract protected function template(): string;
}