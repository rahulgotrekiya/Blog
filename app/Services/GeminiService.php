<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash');
    }

    /**
     * Generate a compelling excerpt from the post body.
     */
    public function generateExcerpt(string $body): string
    {
        $prompt = <<<PROMPT
You are a professional blog editor. Given the following blog post content, write a compelling excerpt/summary in 1-2 sentences (max 150 characters). The excerpt should hook readers and make them want to read the full article.

Rules:
- Return ONLY the excerpt text, nothing else
- No quotes, no labels, no prefixes
- Keep it under 150 characters
- Make it engaging and intriguing

Blog post content:
{$body}
PROMPT;

        return $this->call($prompt);
    }

    /**
     * Suggest the best category for a post.
     */
    public function suggestCategory(string $title, string $body, array $categories): string
    {
        $categoryList = implode(', ', $categories);

        $prompt = <<<PROMPT
You are a content categorization expert. Given the blog post title and content below, determine which category fits best from this list:

Available categories: {$categoryList}

Rules:
- Return ONLY the exact category name from the list above
- Pick the single best match
- If none fit well, return the closest match
- Do not add quotes or any other text

Title: {$title}
Content: {$body}
PROMPT;

        return trim($this->call($prompt), " \t\n\r\"'");
    }

    /**
     * Improve the writing quality of the post body.
     */
    public function improveWriting(string $body): string
    {
        $prompt = <<<PROMPT
You are a professional editor and writing coach. Improve the following blog post text for better grammar, clarity, flow, and engagement.

Rules:
- Fix grammar and spelling errors
- Improve sentence structure and readability
- Maintain the author's voice and original meaning
- Keep the same general length (don't drastically shorten or lengthen)
- Preserve any markdown formatting, headings, or code blocks
- Return ONLY the improved text, no explanations or commentary

Original text:
{$body}
PROMPT;

        return $this->call($prompt);
    }

    /**
     * Generate a structured outline from a title.
     */
    public function generateOutline(string $title): string
    {
        $prompt = <<<PROMPT
You are a professional content strategist. Generate a detailed blog post outline for the following title.

Rules:
- Create 4-6 main sections with descriptive headings
- Under each section, add 2-3 bullet points describing what to cover
- Use plain text with markdown formatting (## for headings, - for bullets)
- Make it actionable and specific, not generic
- Return ONLY the outline, no intro text or explanations

Title: {$title}
PROMPT;

        return $this->call($prompt);
    }

    /**
     * Make the actual API call to Google Gemini.
     */
    protected function call(string $prompt): string
    {
        if (empty($this->apiKey)) {
            throw new \RuntimeException('Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.');
        }

        $url = "{$this->baseUrl}/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::timeout(30)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 2048,
            ],
        ]);

        if ($response->failed()) {
            $errorData = $response->json();
            $errorMsg = $errorData['error']['message'] ?? 'AI service is temporarily unavailable. Please try again.';
            
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $errorData,
            ]);
            
            if ($response->status() === 429) {
                throw new \RuntimeException('Quota exceeded or rate limit hit. Check your Google AI free tier limits or wait a minute.');
            }
            if ($response->status() === 400 && str_contains($errorMsg, 'API key')) {
                throw new \RuntimeException('Invalid Gemini API Key. Please check your .env file.');
            }

            throw new \RuntimeException('Gemini API Error: ' . $errorMsg);
        }

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            Log::warning('Gemini API returned empty response', ['data' => $data]);
            throw new \RuntimeException('AI could not generate a response. Try with different content.');
        }

        return trim($text);
    }
}
