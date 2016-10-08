Frapse Your Settings
====================
Your Settings

Installation
------------


Either run

```
php composer.phar require suver/yii2-settings
```

or add

```
"suver/yii2-settings": "*"
```

Install migrations

```bash
yii migrate --migrationPath=@vendor/suver/yii2-settings/migrations
```

How USE
-------

```php


/**
 * Configure setting 
 */
 
Settings::get('param-int')->configure(Settings::TYPE_INT);
//=> true

Settings::get('param-array')->configure(Settings::TYPE_ARRAY);
//=> true

Settings::get('param-param')->configure(Settings::TYPE_PARAM, [1 => ['text'=>'one'],2 => ['text'=>'two'],3 => ['text'=>'threa']]);
//=> true



/**
 * Set and configure setting 
 */
 
Settings::get('param-int')->configure(Settings::TYPE_INT)->set(4);
//=> true

Settings::get('param-varchar')->configure(Settings::TYPE_VARCHAR)->set("string");
//=> true

Settings::get('param-text')->configure(Settings::TYPE_TEXT)->set("text");
//=> true

Settings::get('param-array')->configure(Settings::TYPE_ARRAY)->set([1,2,3,4]);
//=> true

Settings::get('param-param')->configure(Settings::TYPE_PARAM, [1 => ['text'=>'one'],2 => ['text'=>'two'],3 => ['text'=>'threa']])->set(3);
//=> true

Settings::get('param-option')->configure(Settings::TYPE_OPTIONS, [1=>'one', 2=>'two'])->set(2);
//=> true

Settings::get('param-param')->configure(Settings::TYPE_PARAM, [1 => ['text'=>'one'],2 => ['text'=>'two'],3 => ['text'=>'threa']])->set(5);
//=> Exception



/**
 * Set setting 
 */
 
Settings::get('param-int')->set(4);
//=> true

Settings::get('param-varchar')->set("string");
//=> true


/**
 * Return value 
 */

print Settings::get('param-option-notset')->value(1);
//=> one

print Settings::get('param-option')->value(1);
//=> two

var_dump(Settings::get('param-option')->value(1));
//=> ['text'=>'threa']


var_dump(Settings::get('param-option')->param(1));
//=> 3


/**
 * Delete setting 
 */
 
Settings::get('param-int')->delete();
//=> true



/**
 * Clear setting 
 */
Settings::get('param-varchar')->set("value");
//=> true

Settings::get('param-varchar')->value();
//=> value


Settings::get('param-varchar')->clear(");
//=> true


Settings::get('param-varchar')->value();
//=> null

```
