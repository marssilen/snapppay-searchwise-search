<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => (string) $this->id,
            'title'             => $this->name,
            'slug'              => urlencode($this->slug),
            'subtitle'          => $this->name,
            'link'              => $this->productUrl($this),
            'short_description' => mb_substr($this->short_description ?? '', 0, 100),
            'image_link'        => $this->getProductImages($this), //array of image urls

            'availability'      => $this->stock_status === 'instock'
                ? 'in stock'
                : 'out of stock',

            'regular_price'     => (float) $this->regular_price, // in IRR
            'sale_price'        => (float) ($this->sale_price ?: $this->regular_price), //in IRR

            'category'          =>  '',

            'brand'             => '',

            'description'       => [
                'country'   => '',
                'Compounds' => '',
            ],

            // Optional
            'GTIN'              => '',
            // 'color'          => '',
            // 'size'           => null,
            // 'shipping_cost'  => 0,
            // 'delivery_time'  => 0,
        ];
    }

    protected function productUrl(Product $product): ?string
    {
        if (Route::has('shop.show')) {
            return route('shop.show', $product->slug);
        }

        return url('/product/' . $product->slug);
    }
}