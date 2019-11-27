<?php

namespace wisder\yii\base;

use Yii;
use yii\base\ActionEvent;

class Module extends \yii\base\Module
{
    public $controllerBehaviors;

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_ACTION, [$this, 'extendControllerBehaviors']);
    }

    public function extendControllerBehaviors(ActionEvent $event)
    {
        Yii::debug('extend controller behaviors');
        if (is_array($this->controllerBehaviors)) {
            foreach ($this->controllerBehaviors as $name => $behavior) {
                $action = $event->action;
                $controller = $action->controller;
                $controller->attachBehavior($name, $behavior);
                Yii::debug("extend behavior [{$name}]");
            }
        }
    }
}
