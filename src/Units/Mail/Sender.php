<?php

declare(strict_types=1);

namespace Devitools\Units\Mail;

use Devitools\Persistence\AbstractModel;
use Devitools\Units\Common\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

/**
 * Class Sender
 * @package Devitools\Units\Mail
 */
class Sender extends Mailable
{
    /**
     * @trait
     */
    use Instance;
    use Queueable;
    use SerializesModels;

    /**
     * @var AbstractModel
     */
    public $data;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    private $payload;

    /**
     * @var array
     */
    public array $mailHeaders = [];

    /**
     *
     * Create a new message instance.
     *
     * @param string $template
     * @param array $payload
     */
    public function __construct(string $template, array $payload)
    {
        $locale = Lang::getLocale();
        $this->template = "mail.{$locale}.{$template}";
        $this->payload = $payload;
    }

    /**
     * Register custom text headers applied when the message is built.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function withHeaders(array $headers): self
    {
        $this->mailHeaders = $headers;
        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        if ($this->mailHeaders) {
            $this->withSwiftMessage(function ($message) {
                $headers = $message->getHeaders();
                foreach ($this->mailHeaders as $name => $value) {
                    $headers->addTextHeader($name, $value);
                }
            });
        }
        return $this->view($this->template, $this->payload);
    }

    /**
     * @param string|array $users
     */
    public function dispatch($users): void
    {
        Mail::to($users)->queue($this->onQueue('email'));
    }
}
