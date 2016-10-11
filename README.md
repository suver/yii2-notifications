Frapse Your Notifications
=========================
Your Notifications

Installation
------------


Either run

```
php composer.phar require suver/yii2-notificatoins
```

or add

```
"suver/yii2-notificatoins": "*"
```

Install migrations

```bash
yii migrate --migrationPath=@vendor/suver/yii2-notifications/migrations
```

Configurations
--------------

Add this module in your `modules` and `bootsrap` directive

```
'bootstrap' => [
    'notifications',
],
'modules' => [
        'notifications' => [
            'class' => 'suver\behavior\notifications\Module',
            //      if you wont changed GridView or DataView classes
            //'dataViewWidget' => '\backend\widgets\DataView',
            //'gridViewWidget' => '\backend\widgets\GridView',
        ],
    ],

```

or if you wont include module with access rule configuration you must configure module with `as access` directive like example


```
'bootstrap' => [
    'notifications',
],
'modules' => [
        'notifications' => [
            'class' => 'suver\behavior\notifications\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'controllers'=>['notifications/default'],
                        'allow' => true,
                        'roles' => ['@']                        
                    ],
                    [
                        'controllers'=>['notifications/list'],
                        'allow' => true,
                        'roles' => ['@']                        
                    ],
                    [
                        'controllers'=>['notifications/template'],
                        'allow' => true,
                        'roles' => ['@']                        
                    ],
                ]
            ]
        ],
    ],

```

How USE
-------

```php



```
