<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatchController extends Controller
{
    public function compare(Request $request)
    {
        //
        $request->validate([
            'work_id' => 'required|string',
            'resume_text' => 'nullable|string',
            'resume_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $work = Work::findOrFail($request->work_id);
        $workDescription = "Title: {$work->title}\n";
        $workDescription .= "Description: {$work->description}\n";
        $workDescription .= "Required Skills: " . implode(', ', $work->required_skills ?? []) . "\n";

        $resumeText = $request->input('resume_text');

        if (!$resumeText && $request->hasFile('resume_file')) {
            $parser = new Parser();
            $pdf = $parser->parseFile($request->file('resume_file')->getRealPath());
            $resumeText = $pdf->getText();
        }

        if (!$resumeText) {
            return response()->json(['error' => 'No resume provided'], 400);
        }

        // OPENAI API call
        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a recruitment assistant.'],
                ['role' => 'user', 'content' => "
Compare the following resume and job description, then response to candidate, Return:

1. A match score (0–100)
2. Missing skills or improvements 

Resume:
$resumeText

Job Description:
$workDescription
"]
            ],
            'temperature' => 0.2,
        ]);

        return response()->json([
            'result' => $response['choices'][0]['message']['content'],
        ]);
    }
}
