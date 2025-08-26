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
    public $pdfPath;
    public $pdfFilename;
    public $customSubject;
    public $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($inspectionData, $pdfPath, $pdfFilename, $customSubject = null, $customMessage = null)
    {
        $this->inspectionData = $inspectionData;
        $this->pdfPath = $pdfPath; // Path to saved PDF file
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
        // Check if pdfPath is a full path or relative path
        $fullPath = file_exists($this->pdfPath) 
            ? $this->pdfPath 
            : storage_path('app/public/' . $this->pdfPath);
            
        return [
            Attachment::fromPath($fullPath)
                ->as($this->pdfFilename)
                ->withMime('application/pdf')
        ];
    }
}