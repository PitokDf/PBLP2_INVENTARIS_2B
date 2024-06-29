<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BugReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bugReport;

    public function __construct($bugReport)
    {
        $this->bugReport = $bugReport;
    }

    public function build()
    {
        return $this->view('emails.bug_report')
            ->subject('Laporan Bug Baru')
            ->with('bugReport', $this->bugReport);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bug Report Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bug_report',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}