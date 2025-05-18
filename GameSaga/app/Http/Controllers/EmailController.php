<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'objet' => 'required|string|max:255',
            'contenu' => 'required|string'
        ]);

        try {
            Mail::to('votre-email@example.com')->send(new ContactMail($request->all()));
            
            return response()->json([
                'status' => 'Success',
                'message' => 'Email envoyé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Erreur lors de l\'envoi de l\'email'
            ], 500);
        }
    }
}