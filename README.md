<h1>Simple Cart for Laravel 4</h1>
<h1>Installation</h1>
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
<h2>Remove a product by rowid</h2>
<p>You just need to pass a rowid that there</p>
```php
	Simplecart::remove_item("8e296a067a37563370ded05f5a3bf3ec");
```
<h2>Get cart content</h2>
```php	
	Simplecart::get_content();
```
<h2>Get total cost</h2>
```php	
	Simplecart::total_cart();
```
<h2>Get total items</h2>
```php	
	Simplecart::total_articles();
```
<h2>Destroy simplecart</h2>
```php
	Simplecart::destroy();
```