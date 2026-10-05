<?php

namespace App\Http\Controllers;

use App\Services\ProductFeedService\ProductFeedService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ProductFeedController extends Controller
{
    public function __construct(protected ProductFeedService $feedService)
    {
    }

    /**
     * POST /api/v1/product/feed
     */
    public function feed(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'limit' => 'nullable|integer|min:1|max:200',
            'page' => 'nullable|integer|min:1',
            'products' => 'nullable|string',
            'slugs' => 'nullable|string',
            'include_content' => 'nullable|boolean',
        ]);

        $limit = $validated['limit'] ?? 100;
        $page = $validated['page'] ?? 1;
        $includeContent = $request->boolean('include_content');

        if (!empty($validated['products'])) {
            $ids = array_map('intval', explode(',', $validated['products']));
            $data = $this->feedService->getProductsByIds($ids, $includeContent);
        } elseif (!empty($validated['slugs'])) {
            $slugs = array_map('trim', explode(',', $validated['slugs']));
            $data = $this->feedService->getProductsBySlugs($slugs, $includeContent);
        } else {
            $data = $this->feedService->getAllProducts($limit, $page, $includeContent);
        }

        return response()->json($data);
    }
}
