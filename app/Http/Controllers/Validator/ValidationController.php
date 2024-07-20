<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketValidationRequest;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function validateTicket(TicketValidationRequest $request) 
    {
        $validatedData = $request->validated();
    }
}
