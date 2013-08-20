<h1>Simple Cart for Laravel 4</h1>
<h1>Installation</h1>
<p>Open your composer.json and add the next code</p>
```json
{
	"require": {
	    "laravel/framework": "4.0.*",
	    "unodepiera/simplecart": "dev-master"
	},
	"minimum-stability": "dev"
}
```
<p>Update your packages with composer update or install with composer install.</p>
<h1>Usage</h1>
<p>Find the providers key in app/config/app.php and register the Simplecart Service Provider.</p>
```json
	'providers' => array(
        //...
        'Unodepiera\Simplecart\SimplecartServiceProvider'
    )
```
<p>Find the aliases key in app/config/app.php.</p>
```json
	'aliases' => array(
        //...
        'Simplecart'      => 'Unodepiera\Simplecart\Facades\Simplecart',
    )
```

<h1>Example Usage Simplecart</h1>
<h2>Insert simple row</h2>
```php
	$id = 19;
	$qty = 20;
	$price = 550;
    $item = array(
    	'id' => 5,
        'qty' => $qty,
        'price' => $price,
        'name' => "hair",
        'medida' => "xl"
    );

    //add options to row
    $item["options"] = array("color" => "blue", "avaliable" => "si");

    //add row to cart
    Simplecart::insert($item);
```
<h2>Update a product</h2>
```php
	$update = array(
    	'id' => 5,
        'rowid'	=> "e4da3b7fbbce2345d7772b0674a318d5",
        'qty' => 25,
        'price' => $price,
        'name' => "shirt",
        'medida' => "xl"
    );

    Simplecart::update($update);
```
<h3>Remove a product by rowid</h3>
<p>You just need to pass a rowid that there</p>
```php
	Simplecart::remove_item("8e296a067a37563370ded05f5a3bf3ec");
```
<h3>Get cart content</h3>
```php	
	Simplecart::get_content();
```
<h3>Get total cost</h3>
```php	
	Simplecart::total_cart();
```
<h3>Get total items</h3>
```php	
	Simplecart::total_articles();
```
<h3>Destroy simplecart</h3>
```php
	Simplecart::destroy();
```

<h1>Final example usage</h1>
<p>First visit route insert</p>
```php
Route::get("insert", function(){
	$id = 9;
    $qty = 5;
    $price = 1500;
    $item = array(
        'id' => $id,
        'qty' => $qty,
        'price' => $price,
        'name' => "shirt",
        'medida' => "xxl"
    );

    //add options to row
    $item["options"] = array("color" => "orange", "avaliable" => "yes");

    //add row to cart
    Simplecart::insert($item);
});
```
<h3>Then create the next view and visit the route show</h3>
```php
Route::get("show", function()
{
	$cart = Simplecart::get_content();
	$totalcart = Simplecart::total_cart();
	$totalitems = Simplecart::total_articles();
	return View::make("cart", array("cart" => $cart, "total_cart" => $totalcart, "total_items" => $totalitems));
});
```
<h1>Loop the cart and check if has options</h1>
```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Simplecart for Laravel 4</title>

</head>
<body>
    <table class="simplecart">
        <tr>
            <thead>
                <th>
                    Id
                </th>
                <th>
                    Name
                </th>
                <th>
                    Options
                </th>
                <th>
                    Price
                </th>
                <th>
                    Qty
                </tth>
                <th>
                    Total price
                </tth>
            </thead>
        </tr>
        @foreach($cart as $items)
        <tr>
            <tbody style="text-align:center">
                <td>
                    {{ $items['id'] }}
                </td>
                <td>
                    {{ $items['name'] }}
                </td>
                <td>
                    @if(isset($items['options']))
                        @foreach($items['options'] as $key => $val)
                            {{ $key }}: {{ $val }}
                        @endforeach
                    @else
                        ----
                    @endif
                </td>
                <td>
                    {{ $items['price'] }}
                </td>
                <td>
                    {{ $items['qty'] }}
                </td>
                <td>
                    {{ $items['total'] }}
                </td>
            </tbody>
        </tr>
        @endforeach
        <tr>
            <td colspan="3">Total: {{ $total_cart }}</td>
            <td colspan="3">Items: {{ $total_items }}</td>
        </tr>
    </table>
</body>
</html>
```
## Visit me

* [Visit me](http://uno-de-piera.com)
* [SimpleCart on Packagist](https://packagist.org/packages/unodepiera/simplecart)
* [License](http://www.opensource.org/licenses/mit-license.php)
* [Laravel website](http://laravel.com)-