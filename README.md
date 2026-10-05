# snapppay-searchwise-search
This is a Snapppay/Searchwise friendly resource JSON for Laravel so it can load and show your products in Snapppay application


```
use App\Http\Resources\ProductCollection;
use App\Models\Product;

public function index(Request $request)
{
    $products = Product::query()
        ->with('categories')
        ->paginate($request->input('per_page', 20));

    return new ProductCollection($products);
}
```

~Without pagination (plain collection)
```
$products = Product::with('categories')->get();

return new ProductCollection($products);
```