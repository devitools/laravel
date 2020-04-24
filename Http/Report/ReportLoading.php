<?php

declare(strict_types=1);

namespace DeviTools\Http\Report;

use App\Http\Controllers\Controller;

/**
 * Class ReportLoading
 *
 * @package DeviTools\Http\Report
 */
class ReportLoading extends Controller
{
    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @return mixed
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke()
    {
        return view('report.layout.loading');
    }
}