<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = ProductResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'count'     => $this->collection->count(),
            'max_pages' => $this->maxPages($request),
            'products'  => $this->collection,
        ];
    }

    /**
     * Figure out max pages — works with paginators, falls back to 1.
     */
    protected function maxPages(Request $request): int
    {
        $resource = $this->resource;

        // LengthAwarePaginator / Paginator
        if ($resource instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
            return $resource->lastPage();
        }

        if ($resource instanceof \Illuminate\Contracts\Pagination\Paginator) {
            return $resource->lastPage();
        }

        // If pagination info is passed some other way (e.g. per_page on request)
        $perPage = (int) $request->input('per_page', $this->collection->count() ?: 1);

        return $perPage > 0
            ? (int) ceil($this->collection->count() / $perPage)
            : 1;
    }
}