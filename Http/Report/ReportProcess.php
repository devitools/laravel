<?php

declare(strict_types=1);

namespace Simples\Http\Report;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use RuntimeException;
use Simples\Report\AbstractReport;

/**
 * Class ReportProcess
 *
 * @package App\Http\Report
 */
class ReportProcess extends Controller
{
    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @param Request $request
     * @param string $report
     *
     * @return mixed
     * @throws Exception
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke(Request $request, string $report)
    {
        $name = ucfirst($report);
        $fullQualifiedName = "\\App\\Report\\{$name}";
        if (!class_exists($fullQualifiedName)) {
            throw new RuntimeException("Invalid report '{$report}'");
        }

        $user = auth()->user()->name;
        $printing = $request->get('p') === 'true';
        $filters = $request->post();

        /** @var AbstractReport $fullQualifiedName */
        return $fullQualifiedName
            ::build($user, $printing)
            ->execute($filters);
    }
}