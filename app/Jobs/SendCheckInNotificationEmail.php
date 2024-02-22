<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        // Construct the email message
        $message = '<p>You have successfully Arrived at ' . $this->checkInTime . 'at Job</p>';

        // Send the email using Mailtrap
        Mail::raw($message, function ($mail) {
            $mail->to($this->employeeEmail)
                ->from('admin@employee.io')
                ->subject('Arriving at Job');
        });

        // Log success message
        \Log::info('Check-in notification email sent successfully.');
    }
}
