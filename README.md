Frapse Your Notifications
=========================
Your Notifications

Installation
------------


Either run

```
php composer.phar require suver/yii2-notifications
```

or add

```
"suver/yii2-notifications": "*"
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
            'class' => 'suver\notifications\Module',
            // or
            //'detailViewWidget' => '\app\widgets\DetailView',
            //'gridViewWidget' => '\app\widgets\GridView',
            'identityClass' => '\app\models\User',
            'channels' => [
                [   // Email channel
                    'class' => '\suver\notifications\EmailChannel',
                    'init' => [
                        'from' => 'mail@example.com',
                    ],
                    'config' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => 'smtp.yandex.ru',
                            'username' => 'mail@example.com',
                            'password' => '****',
                            'port' => '465',
                            'encryption' => 'ssl',
                        ],
                    ],
                ],
                [   // Yii2 Flash channel
                    'class' => '\suver\notifications\FlashNotificationsChannel',
                    'init' => [
                        'key' => 'info',
                    ],
                    'config' => [],
                ],
            ],
        ];
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
            'identityClass' => '\app\models\User',
            'channels' => [
                [   // Email channel
                    'class' => '\suver\notifications\EmailChannel',
                    'init' => [
                        'from' => 'mail@example.com',
                    ],
                    'config' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => 'smtp.yandex.ru',
                            'username' => 'mail@example.com',
                            'password' => '****',
                            'port' => '465',
                            'encryption' => 'ssl',
                        ],
                    ],
                ],
                [   // Yii2 Flash channel
                    'class' => '\suver\notifications\FlashNotificationsChannel',
                    'init' => [
                        'key' => 'info',
                    ],
                    'config' => [],
                ],
            ],
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

Notifications::get('news-add', 1) // Return new instance notification model from "news-add" template for user with id=1
    ->setParams(['newsLink' => Url::to(['/news-feed/default/' . $event->sender->id], true)]) // set parrams for replace "{{newsLink}}" => /news-feed/default/1
    ->send(); // send message. 
    
// Set new message body
Notifications::get('news-add', 1)->setMessage($message) 

// Set new message body & new subject
Notifications::get('news-add', 1)->setMessage($message)->setSubject($subject) 

// Set new message body & new subject & hold over message
Notifications::get('news-add', 1)->setMessage($message)->setSubject($subject)->holdOver() 

// Select "flash-notifications" channel & set new message body & new subject & hold over message
Notifications::get('news-add', 1)->setChannel('flash-notifications')->setMessage($message)->setSubject($subject)->holdOver() 
    
// Send notifications for all user selected channel
// You must implements UserNotificationsInterface and return from getNotificationChannels() method channel array as ['email', 'flash-notifications', 'and', 'other', 'notify']
Notifications::get('news-add', 1)->sendUserChannels()
 

```

How add new channel of notifications 
------------------------------------

configuration you channel

```

'channels' => [
    [   // You channel
        'class' => '\you\path\YouChannel',
        'init' => [
            // your init settings
        ],
        'config' => [
            // your transport settings
        ],
    ],

```

and write channel class as example

```php

namespace suver\notifications;

use Yii;
use suver\notifications\models\Notifications as NotificationsModel;

/**
 * Class Notification
 * @package yii2-notifications
 */
class YouChannel implements ChannelInterface
{
    public $class;
    public $config;
    public $init;

    public function __construct($app, $config, $init) {
        $this->config = $config;
        $this->init = $init;
        $app->components = [
            // configure you needed components
        ];
    }

    public function getChannelName() {
        return 'you-channel-name';
    }

    public function init($config) {
        $this->config = $config;
    }

    public function send(NotificationsModel $object, $user) {
        $subject = $object->getSubject();
        $message = $object->getMessage();

        Yii::$app->session->setFlash($this->init['key'], $subject . " | " . $message);
        
        return true;
    }



}


```
