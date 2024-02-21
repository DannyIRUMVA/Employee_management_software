<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Postmark\PostmarkClient;

class SendCheckInNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeEmail;
    protected $checkInTime;

    public function __construct($employeeEmail, $checkInTime)
    {
        $this->employeeEmail = $employeeEmail;
        $this->checkInTime = $checkInTime;
    }

    public function handle()
    {
        // Create a new Postmark client
        $client = new PostmarkClient(env('MAILPIT_API_TOKEN'));

        // Construct the email message
        $message = [
            'From' => 'your-email@example.com',
            'To' => $this->employeeEmail,
            'Subject' => 'Check-in Notification',
            'HtmlBody' => '<p>You have successfully checked in at ' . $this->checkInTime . '</p>',
        ];

        // Send the email
        $sendResult = $client->sendEmail($message);

        // Check if the email was sent successfully
        if ($sendResult['ErrorCode'] === 0) {
            // Email sent successfully
            \Log::info('Check-in notification email sent successfully.');
        } else {
            // Email sending failed
            \Log::error('Check-in notification email sending failed: ' . $sendResult['ErrorMessage']);
        }
    }
}

