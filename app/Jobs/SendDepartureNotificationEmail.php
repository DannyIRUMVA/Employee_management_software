<?php

namespace App\Jobs;

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
        $message = '<p>You have successfully Checked out at ' . $this->checkOutTime . ' from Job</p>';

        Mail::raw($message, function ($mail) {
            $mail->to($this->employeeEmail)
                ->from('admin@employee.io')
                ->subject('Checking out from Job');
        });

        \Log::info('Check-out notification email sent successfully.');
    }
}
