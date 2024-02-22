<?php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDepartureNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeEmail;
    protected $checkOutTime;

    public function __construct($employeeEmail, $checkOutTime)
    {
        $this->employeeEmail = $employeeEmail;
        $this->checkOutTime = $checkOutTime;
    }

    public function handle()
    {
        // Construct the email message
        $message = '<p>You have successfully left the job at ' . $this->checkOutTime . '.</p>';

        // Send the email using Mailtrap
        Mail::raw($message, function ($mail) {
            $mail->to($this->employeeEmail)
                ->from('admin@employee.io')
                ->subject('Departure from Job');
        });

        // Log success message
        \Log::info('Departure notification email sent successfully.');
    }
}
