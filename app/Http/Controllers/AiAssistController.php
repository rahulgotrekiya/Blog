<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AiAssistController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Generate an excerpt from the post body.
     */
    public function generateExcerpt(Request $request): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|min:50',
        ]);

        try {
            $excerpt = $this->gemini->generateExcerpt($request->body);
            return response()->json(['success' => true, 'excerpt' => $excerpt]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Suggest the best category for a post.
     */
    public function suggestCategory(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|min:3',
            'body' => 'nullable|string',
        ]);

        try {
            $categories = Category::pluck('name')->toArray();

            if (empty($categories)) {
                return response()->json([
                    'success' => false,
                    'error' => 'No categories exist. Create some categories first.',
                ], 422);
            }

            $suggested = $this->gemini->suggestCategory(
                $request->title,
                $request->body ?? '',
                $categories
            );

            // Find the matching category to return its ID
            $category = Category::whereRaw('LOWER(name) = ?', [strtolower($suggested)])->first();

            return response()->json([
                'success' => true,
                'category' => $suggested,
                'category_id' => $category?->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Improve the writing quality of the post body.
     */
    public function improveWriting(Request $request): JsonResponse
    {
        $request->validate([
            'body' => 'required|string|min:50',
        ]);

        try {
            $improved = $this->gemini->improveWriting($request->body);
            return response()->json(['success' => true, 'body' => $improved]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Generate a structured outline from a title.
     */
    public function generateOutline(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|min:3',
        ]);

        try {
            $outline = $this->gemini->generateOutline($request->title);
            return response()->json(['success' => true, 'outline' => $outline]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
