<?php
namespace suver\notifications;


/**
 * User Notifications interface
 *
 */
interface UserNotificationsInterface
{
    /**
     * Венет список выбранных типов отправки уведомлений
     * @return []
     */
    public function getNotificationChannels();

}
