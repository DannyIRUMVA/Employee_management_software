<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Attendance;
use Carbon\Carbon;

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
        $message = '<p>You have successfully checked in at ' . $this->checkInTime . '.</p>';

        Mail::raw($message, function ($mail) {
            $mail->to($this->employeeEmail)
                ->from('admin@example.com')
                ->subject('Check-In Notification');
        });
    }
}

