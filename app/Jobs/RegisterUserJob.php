<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use App\User;
use Validator;

class RegisterUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $phone;
    protected $address;
    protected $dob;
    protected $isVaccinated;
    protected $vaccineName;
    public function __construct($firstName, $lastName, $email, $phone, $address, $dob, $isVaccinated, $vaccineName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->dob = $dob;
        $this->isVaccinated = $isVaccinated;
        $this->vaccineName = $vaccineName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = new User;
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->email = $this->email;
        $user->phone_number = $this->phone;
        $user->address = $this->address;
        $user->date_of_birth = $this->dob;
        $user->is_vaccinated = $this->isVaccinated;
        $user->vaccine_name = $this->vaccineName;
        $user->save();
    }
}
