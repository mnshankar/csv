[![Build Status](https://travis-ci.org/mnshankar/csv.png)](https://travis-ci.org/mnshankar/csv)

## Easy CSV file manipulation (Read, Write and Download)

This is a simple utility package that helps you work with CSV files.

##Installation with Composer

Add this line to your composer.json file in the `require field:

```json
"mnshankar/CSV": "1.8"
```
##Generic PHP Project or Laravel 5+ Project

Since this package does not have any framework specific dependencies (or any dependencies for that matter), directly instantiate a CSV object in your code like so
```
$csvObj = new mnshankar\CSV\CSV();
```
Then, use regular PHP object calls like so:
```
$arr = array(
    array('col1'=>'a','col2'=>'b'),
    array('col1'=>'1','col2'=>'2'),
    array('col1'=>'3','col2'=>'4'),
);
return $csvObj->fromArray($arr)->render('myfile.csv');                  //download as csv;
return $csvObj->fromArray($arr)->withSeparator()->render('myfile.csv'); //add delimiter for better excel compatibility & download
return $csvObj->with($arr)->put('/downloads/myusers.csv');	            //store as csv in this path
return $csvObj->fromFile('/downloads/my.csv')->toArray();               //return csv file as an array
return $csvObj->fromFile('/downloads/my.csv')->render('abc.csv');       //render saved csv file as a downloadable document
return $csvObj->with('/downloads/my.csv')->render('abc.csv');           //use 'with'.. same as previous
```

##Laravel 4
CSV has (optional) support for Laravel, and comes with a Service Provider and Facades for easy integration.
Open `app/config/app.php` and add the following line in the `providers` array:

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
