<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class InspectionReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inspectionData;
    public $pdfContent;
    public $pdfFilename;
    public $customSubject;
    public $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($inspectionData, $pdfContent, $pdfFilename, $customSubject = null, $customMessage = null)
    {
        $this->inspectionData = $inspectionData;
        $this->pdfContent = $pdfContent;
        $this->pdfFilename = $pdfFilename;
        $this->customSubject = $customSubject;
        $this->customMessage = $customMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->customSubject ?: 'Vehicle Inspection Report - ' . ($this->inspectionData['vehicle']['make'] ?? '') . ' ' . ($this->inspectionData['vehicle']['model'] ?? '');
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inspection-report',
            with: [
                'inspectionData' => $this->inspectionData,
                'customMessage' => $this->customMessage,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->pdfFilename)
                ->withMime('application/pdf')
        ];
    }
}