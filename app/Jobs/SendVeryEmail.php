<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\VeryEmail;
use Illuminate\Support\Facades\Log;

class SendVeryEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $email;
    public $name;
    public $token;
    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new VeryEmail($this->name, $this->token));
    }

    public function failed(\Throwable $exception)
    {
        Log::error('SendEmailJob fail 😭: ' . $exception->getMessage());
    }
}
