<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Mailer\Exception\TransportException;

class ContactController extends Controller
{
    public function sendContactEmail(Request $request)
    {
        try {
            $validated = $request->validate([
                'objet' => 'required|string|max:255|min:3',
                'content' => 'required|string|min:10|max:1000'
            ], [
                'objet.required' => 'L\'objet est obligatoire',
                'objet.min' => 'L\'objet doit contenir au moins 3 caractères',
                'objet.max' => 'L\'objet ne peut pas dépasser 255 caractères',
                'content.required' => 'Le contenu est obligatoire',
                'content.min' => 'Le message doit contenir au moins 10 caractères',
                'content.max' => 'Le message ne peut pas dépasser 1000 caractères'
            ]);

            $spamKeywords = ['casino', 'viagra', 'lottery', 'winner'];
            $content = strtolower($validated['content']);
            foreach ($spamKeywords as $keyword) {
                if (str_contains($content, $keyword)) {
                    Log::warning('Spam détecté', [
                        'keyword' => $keyword,
                        'ip' => $request->ip()
                    ]);
                    return response()->json([
                        'status' => 'Error',
                        'message' => 'Message détecté comme spam'
                    ], 400);
                }
            }

            try {
                Mail::to(config('mail.from.address'))->send(new ContactMail($validated));
            } catch (TransportException $e) {
                Log::error('Erreur d\'envoi email', [
                    'error' => $e->getMessage(),
                    'ip' => $request->ip()
                ]);
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer plus tard.'
                ], 503);
            }

            Log::info('Email envoyé avec succès', [
                'objet' => $validated['objet'],
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'Success',
                'message' => 'Email envoyé avec succès'
            ], 200);

        } catch (ValidationException $e) {
            Log::warning('Erreur de validation', [
                'errors' => $e->errors(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'Error',
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur inattendue', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip()
            ]);

            $message = app()->environment('local') 
                ? $e->getMessage() 
                : 'Une erreur inattendue est survenue';

            return response()->json([
                'status' => 'Error',
                'message' => $message
            ], 500);
        }
    }
}