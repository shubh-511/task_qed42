<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jobs\RegisterUserJob;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Rees\Sanitizer\Sanitizer;
use Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required|max:100',
            'last_name' =>  'required|max:100',
            'email'     =>  'required|email|max:100',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:10',
            'date_of_birth' =>  'date_format:Y-m-d|before_or_equal:today',
            'is_vaccinated' => [Rule::in(['yes', 'no'])],
            'vaccine_name'  => ['required_if:is_vaccinated,yes', Rule::in(['covaxin', 'covishield'])]
            
        ]);

        if ($validator->fails()) { 
            return response()->json(['errors'=>$validator->errors()->first(),'success' => 409], 409);
        }

        $rules = [
            'first_name' => 'trim',
            'last_name'  => 'trim',
            'email'  => 'trim',
            'phone_number'  => 'trim',
            'address'  => 'trim',
            'date_of_birth'  => 'trim',
            'is_vaccinated'  => 'trim',
            'vaccine_name'  => 'trim'
        ];

        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'  => $request->email,
            'phone_number'  => $request->phone_number,
            'address'       =>  $request->address,
            'date_of_birth'  => $request->date_of_birth,
            'is_vaccinated'  => $request->is_vaccinated,
            'vaccine_name'  => $request->vaccine_name,
        ];

        $sanitizer = new Sanitizer;

        RegisterUserJob::dispatch($data['first_name'], $data['last_name'] , $data['email'], $data['phone_number'], $data['address'], $data['date_of_birth'], $data['is_vaccinated'], $data['vaccine_name']);

        return response()->json(['success' => 200,
                                 'message' => "User registered successfully",
                                ], 200);
    }
}
