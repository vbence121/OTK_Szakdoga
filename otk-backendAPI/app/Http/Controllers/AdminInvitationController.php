<?php

namespace App\Http\Controllers;

use App\Models\AdminInvitation;
use Illuminate\Http\Request;

class AdminInvitationController extends Controller
{
    
    public function store(Request $request) //StoreInvitationRequest $request
    {
        if((auth()->user()->tokens->first()['name'] != 'adminToken')){ // Stop users withouth adminToken from accessing protected functions
            return response(
                ['result' => 'Bad Token. Unauthorized access of endpoint'], 403
            );
        }

        $request->validate([
            'email' => 'string|email|unique:AdminInvitations',
        ],
        [
            'email.unique' => 'Invitation with this email address already requested.'
        ]);

        $invitation = new AdminInvitation($request->all());
        $invitation->generateInvitationToken();
        $invitation->save();

        return response('success', 201); //Invitation to register successfully requested. Please wait for registration link.
    }
}
