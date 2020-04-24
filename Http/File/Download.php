<?php

declare(strict_types=1);

namespace Simples\Http\File;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use function request;

/**
 * Class Download
 *
 * @package Simples\Http\File
 */
class Download extends Controller
{
    /**
     * @var array
     */
    public const HEADERS = [
        'pdf' => [
            'Content-Type' => 'application/pdf'
        ],
        'jpg' => [
            'Content-Type' => 'image/png'
        ],
        'jpeg' => [
            'Content-Type' => 'image/png'
        ],
        'png' => [
            'Content-Type' => 'image/png'
        ],
        'mp3' => [
            'Content-Type' => 'audio/mpeg'
        ],
        'mp4' => [
            'Content-Type' => 'video/mp4'
        ],
    ];

    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @param string $any
     *
     * @return false|Factory|View|string
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke($any)
    {
        $resource = addslashes($any);
        try {
            $path = preg_replace('/\\.[^.\\s]{3,4}$/', '', $resource);
            $content = Storage::disk('minio')->get($path);
        } catch (FileNotFoundException $fileNotFoundException) {
            return response(null, 404);
        }

        $info = pathinfo($resource);
        $extension = $info['extension'] ?? '';
        $headers = static::HEADERS[$extension] ?? ['Content-Type' => 'text/html'];

        if (request()->get('download')) {
            $name = request()->get('name');
            if (!$name) {
                $name = 'download' . '.' . $extension;
            }
            $filename = storage_path() . '/temp/' . uniqid('static', true);
            file_put_contents($filename, $content);
            return response()->download($filename, $name, $headers)->deleteFileAfterSend();
        }

        return Response::make($content, 200, $headers);
    }
}
