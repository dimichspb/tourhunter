<?php
namespace app\forms\user;

use yii\base\Model;

class SearchForm extends Model
{
    public $username;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'string'],
        ];
    }
}