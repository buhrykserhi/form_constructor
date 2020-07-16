<?php

/**
 * Description of FileSaveBehavior
 *
 * @author postolachiserghei
 */

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class JsonFields extends \yii\base\Behavior
{

    public $fields;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    /**
     * encode json before save
     */
    public function beforeSave()
    {
        foreach ($this->fields as $f) {

            $post = !yii::$app->request->isConsoleRequest ? yii::$app->request->post($this->owner->shortClassName) : null;
            if ($post && isset($post[$f])) {
                if (is_array($post[$f])) {
                    $this->owner->{$f} = ArrayHelper::merge((is_array($this->owner->{$f}) ? $this->owner->{$f} : []), $post[$f]);
                } else {
                    $this->owner->{$f} = $post[$f];
                }
            }

            $data = $this->owner->{$f};
            if ($f == 'additional_data') {
                if (yii::$app->request->isConsoleRequest) {
                    $defaultData['info'] = [
                        'triggered by console application'
                    ];
                } else {
                    $defaultData['info'] = [
                        'user' => (yii::$app->user->isGuest ? 'guest' : yii::$app->user->id),
                        'ip' => yii::$app->request->userIP,
                    ];
                }
                $data = is_array($data) ? array_merge($defaultData, $data) : $defaultData;
            }
            $this->owner->{$f} = Json::encode($data);
        }
    }

    /**
     * decode json after find
     */
    public function afterFind()
    {
        foreach ($this->fields as $f) {
            $this->owner->{$f} = Json::decode(($this->owner->{$f} ? $this->owner->{$f} : null));
        }
    }

    /**
     * get data attribute
     * @param string $attribute
     * @param string $field
     * @param boolean $oldAttributes
     * @return mixed
     */
    public function getData($attribute, $field = null, $oldAttributes = false)
    {
        if (!$field) {
            if (!is_array($this->fields) || count($this->fields) === 0) {
                return null;
            }
            $field = $this->fields[0];
        }
        if (mb_strrpos($attribute, $field . '[')) {
            $attribute = str_replace('[', '.', $attribute);
            $attribute = str_replace(']', '', $attribute);
        }
        $values = $oldAttributes === true ? $this->owner->getOldAttribute($field) : $this->owner->{$field};
        if (!is_array($values) && $json = Json::decode($values, true)) {
            $values = $json;
        }
        if (!is_array($values)) {
            return null;
        }
        $valuePath = str_replace($field . '.', '', $attribute);
        $result = ArrayHelper::getValue($values, $valuePath, null);
        if (!$result && ($this->owner->hasProperty($attribute))) {
            $result = $this->owner->{$attribute};
        }
        return $result;
    }

    /**
     * set attribute
     * @param string $attribute attribute | attribute.sub_attribute.sub_attribute_1 ...
     * @param mixed $value
     * @param string $field default is additional_data
     * @return type
     */
    public function setData($attribute, $value, $field = null)
    {

        if (!$field) {
            if (!is_array($this->fields) || count($this->fields) === 0) {
                return null;
            }
            $field = $this->fields[0];
        }

        if (mb_strrpos($attribute, $field . '[')) {
            $attribute = str_replace('[', '.', $attribute);
            $attribute = str_replace(']', '', $attribute);
        }
        if (!is_array($this->owner->{$field}) && $this->isJson($this->owner->{$field})) {
            $this->owner->{$field} = Json::decode($this->owner->{$field});
        }

        $ar = [$attribute => $value];
        return $this->owner->{$field} = is_array($this->owner->{$field}) ? array_merge($this->owner->{$field}, $ar) : $ar;
    }

    /**
     *
     * @param type $string
     * @return type
     */
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}
