<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::create();
        return $this->from('ikoolik@yandex.ru')
            ->subject("Отчет на {$date->format('Y-m-d')}")
            ->view('report', $this->data);
    }
}
