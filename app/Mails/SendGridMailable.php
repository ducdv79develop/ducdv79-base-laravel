<?php


namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;

class SendGridMailable extends Mail
{
    use Queueable, SerializesModels;

    protected $data;

    protected $sender;

    protected $from;

    protected $mailer;

    /**
     * SGMailable constructor.
     * @param $data
     * @param null $from
     * @throws SendGrid\Mail\TypeException
     */
    public function __construct($data, $from = null)
    {
        parent::__construct();
        $this->from = $from ?? config('mail_setting.sendgrid.from');
        $this->sender = config('mail_setting.sendgrid.name');
        $this->data = $data;

        $this->mailer = new SendGrid(config('mail_setting.sendgrid.api_key'));
        $this->from($this->from, $this->sender);
    }

    public function to($to, $receiver = '')
    {
        Log::info("To: $to");
        $this->addTo($to, $receiver);
        return $this;
    }

    public function tos($mails)
    {
        // template $mails = [ email1 => name1, email2 => name2 ];
        if (count($mails) > 0) {
            Log::info("To: " . json_encode($mails));
            $this->addTos($mails);
        }
        return $this;
    }

    public function from($from, $sender)
    {
        Log::info("From: $from");
        $this->setFrom($from, $sender);
        return $this;
    }

    public function cc($cc)
    {
        $this->addCc($cc);
        return $this;
    }

    public function ccs($cc = [])
    {
        if (count($cc) > 0) {
            $this->addCcs($cc);
        }
        return $this;
    }

    public function bCCs($bcc = [])
    {
        $this->addBccs($bcc);
        return $this;
    }

    public function attach($resource)
    {
        $this->addAttachments($resource);
        return $this;
    }

    public function subject($subject)
    {
        Log::info("subject: $subject");
        $this->setSubject($subject);

        return $this;
    }

    public function view($view, array $data = [])
    {
        $content = view($view, $data)->render();
        $this->addContent("text/html", $content);

        return $this;
    }

    public function send()
    {
        Log::info("[SendGrid] sending");
        $response = $this->mailer->send($this);
        Log::info('[SendGrid] receiving: ' . json_encode($response));
    }

    public function body($body)
    {
        $this->addContent("text/html", $body);
        return $this;
    }
}
