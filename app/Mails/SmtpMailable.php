<?php


namespace Core\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SmtpMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailTo = [];
    protected $mailCc = [];

    /**
     * SMTPMailable constructor.
     * @param null $senderName
     */
    public function __construct($senderName = null)
    {
        $from = config('mail_setting.smtp.from');
        $sender = $senderName ?? config('mail_setting.smtp.name_admin');
        $this->setFrom($from, $sender);
    }

    public function to($address, $name = null)
    {
        $this->mailTo[] = $address;
        return $this->setAddress($address, $name, 'to');
    }

    public function tos($emails)
    {
        if (count($emails) == 0) return $this;

        foreach ($emails as $mail => $name) {
            $this->mailTo[] = $mail;
            $this->setAddress($mail, $name, 'to');
        }
        return $this;
    }

    public function cc($address, $name = null)
    {
        $this->mailCc[] = $address;
        return $this->setAddress($address, $name, 'cc');
    }

    public function ccs($emails)
    {
        if (count($emails) == 0) return $this;

        foreach ($emails as $mail => $name) {
            $this->mailCc[] = $mail;
            $this->setAddress($mail, $name, 'cc');
        }
        return $this;
    }

    public function subject($subject): SMTPMailable
    {
        $this->subject = $subject;
        return $this;
    }

    public function setFrom($from, $sender): SMTPMailable
    {
        Log::info("[SmtpMailable] sending");
        Log::info("From: $from");
        $this->from[] = [
            'address' => $from,
            'name' => $sender,
        ];
        return $this;
    }

    public function executeSend()
    {
        $mailSend = Mail::to($this->mailTo);
        if (count($this->mailTo) == 1) {
            Log::info("To: {$this->mailTo[0]}");
        } else {
            foreach ($this->mailTo as $idx => $mail) {
                Log::info("To $idx: $mail");
            }
        }
        if ($this->mailCc) {
            if (count($this->mailCc) == 1) {
                Log::info("Cc: {$this->mailCc[0]}");
            } else {
                foreach ($this->mailCc as $idx => $mail) {
                    Log::info("Cc $idx: $mail");
                }
            }
            $mailSend->cc($this->mailCc);
        }

        Log::info("Subject: $this->subject");
        $response = $mailSend->send($this);
        Log::info('[SmtpMailable] receiving: ' . json_encode($response));
    }
}
