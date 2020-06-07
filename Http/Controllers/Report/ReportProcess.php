<?php

declare(strict_types=1);

namespace Devitools\Http\Controllers\Report;

use Devitools\Http\Controllers\Controller;
use Devitools\Exceptions\ErrorRuntime;
use Devitools\Exceptions\ErrorValidation;
use Devitools\Report\AbstractReport;
use Exception;
use Illuminate\Http\Request;

/**
 * Class ReportProcess
 *
 * @package Devitools\Http\Report
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
        $auth = auth();
        if ($auth->guest()) {
            throw new ErrorValidation(['session' => 'required']);
        }

        $user = $auth->user();
        if (!$user) {
            throw new ErrorValidation(['user' => 'required']);
        }

        $name = ucfirst($report);
        $fullQualifiedName = "\\Devitools\\Report\\{$name}";
        if (!class_exists($fullQualifiedName)) {
            throw new ErrorRuntime(['report' => $report]);
        }

        $printing = $request->get('p') === 'true';
        $filters = $request->post();

        /** @var AbstractReport $fullQualifiedName */
        return $fullQualifiedName
            ::build($user->name, $printing)
            ->execute($filters);
    }
}
