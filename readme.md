## Easy CSV file manipulation (Read, Write and Download)

This is a simple utility package that helps you work with CSV files
using a succinct and readable syntax popularised by Laravel 4.

##Installation with Composer

Add this line to your composer.json file in the `require field:

```json
"mnshankar/CSV": "dev-master"
```

Then open `app/config/app.php` and add the following line in the `providers` array:

```php
'providers' => array(
    'mnshankar\CSV\CSVServiceProvider',
)
```
and the following in the 'alias' array

```php
'alias' => array(
    'CSV'             =>'mnshankar\CSV\CSVFacade',
)
```
Now, in your application you can work with CSV files like so:

```php
$arr = User::all()->toArray();	//use eloquent to get array of all users in 'users' table

return CSV::with($arr)->put(storage_path().'/downloads/myusers.csv');	//store as csv in this path
return CSV::fromArray($arr)->render();	//download as csv
return CSV::fromFile(storage_path().'/downloads/my.csv')->toArray();    //return csv file as an array
return CSV::fromFile(storage_path().'/downloads/my.csv')->render('abc.csv'); //render saved csv file as a downloadable document
return CSV::with(storage_path().'/downloads/my.csv')->render('abc.csv'); //use 'with'.. same as previous
```    

Note that the 'with' statement can accept either an array or file path, and work accordingly.

### License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)