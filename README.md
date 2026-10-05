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

{
  "count": 25,
  "max_pages": 1,
  "products": [
    {
      "id": 1,
      "title": "",
      "slug": "student-breakfast-package-rozbon",
      "subtitle": "",
      "link": "",
      "short_description": "",
      "image_link": ["",""],
      "availability": "in stock", //out of stock
      "regular_price": 100000, //IRR
      "sale_price": 100000, //IRR can not be 0. if there is no discouont should be the same as regular_price
      "category": "",
      "brand": "",
      "description": {
        "compounds": ""
      }
    //Also optional
    //"color" : "",
    //"size" : "",
    //"shipping_cost" : 0, //IRR
    //"delivery_time" : "1",
    }
  ]
}