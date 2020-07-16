<?php
namespace common\behaviors;

use yii\base\Behavior;

class PositionBehavior extends Behavior
{
    public $params = [];

    public function setPosition()
    {
       $class = $this->owner->className();
       $query = $class::find();
       if ($this->params) {
           $query->where($this->params);
       }

       $max = $query->max('position');
       $position = $max ? $max : 0;

       $this->owner->position = $position + 1;
    }

    public function events()
    {
        return [
            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'setPosition',
        ];
    }
}