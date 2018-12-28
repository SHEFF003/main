<?php
namespace components\Validator;


use components\Enum\DenyLogin;
use components\Exceptions\RegistrationException;
use Illuminate\Support\Str;


/**
 * Class RegistrationValidator
 * @package components\Validator
 */
class RegistrationValidator
{

    /**
     * Extend validator with new rule
     */
    public static function registerRegistrationRules()
    {

        \Validator::extend(
            'valid_login_klan',
            function ($attribute, $value, $parameters)
            {
                return
                    (stripos($value, 'klan') === false) &&
                    (stripos($value, "mklan") === false);
            }
        );


        \Validator::extend(
            'valid_deny_login',
            function ($attribute, $value, $parameters)
            {
                return DenyLogin::isDenny($value) ? false : true;
            }
        );

        \Validator::extend(
            'underscore',
            function ($attribute, $value, $parameters)
            {
                if (
                    preg_match("/^(_| )/", $value) ||
                    preg_match("/(_| )$/", $value)
                ) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'multi_underscore',
            function ($attribute, $value, $parameters)
            {
                if (
                    preg_match("/__/", $value) ||
                    preg_match("/--/", $value) ||
                    preg_match("/  /", $value)
                ) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'same_characters',
            function ($attribute, $value, $parameters)
            {
                if (
                    preg_match("/(.)\\1\\1\\1/", $value) ||
                    preg_match("/[\d]{5,}/", $value)
                ) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'characters',
            function ($attribute, $value, $parameters)
            {
                if (
                    preg_match("~[a-zA-Z]~", $value) &&
                    preg_match("~[�-��-߸�]~", $value)
                ) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'basic_rule',
            function ($attribute, $value, $parameters)
            {
                if (!preg_match("~^[a-zA-Z�-��-�0-9-][a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9-]$~", $value)) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'custom_min',
            function ($attribute, $value, $parameters)
            {
                if (Str::length($value, 'windows-1251') < $parameters[0]) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'custom_max',
            function ($attribute, $value, $parameters)
            {
                if (Str::length($value, 'windows-1251') > $parameters[0]) {
                    return false;
                }

                return true;
            }
        );

        \Validator::extend(
            'login_rvs',
            function ($attribute, $value, $parameters)
            {
                return $value !== '/?RVS';
            }
        );

    }

    public static function validate($params)
    {
        $messages = [
            'login.unique' => "� ��������� �������� � ����� <B>{$params['login']}</B> ��� ���������������.",
            'login.required' => '������� ��� ���������!',
            'login.login_rvs' => '��������� ������������ ����� �����',
            'login.custom_min' => '����� ����� ��������� �� 4 ��������',
            'login.custom_max' => '����� ����� ��������� �� 20 ��������',
            'login.valid_login_klan' => "����������� ��������� � ����� <B>{$params['login']}</B> ���������!",
            'login.valid_deny_login' => "����������� ��������� � ����� <B>{$params['login']}</B> ���������!",
            'login.underscore' => "����� �� ����� ���������� ��� ������������� �������� ��� �������� '_'.",
            'login.multi_underscore' => "� ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-' � ����� 1 �������.",
            'login.same_characters' => "� ������ �� ������ �������������� ������ ����� 3-� ������ ���������� �������� ��� ����� 4-� ����.",
            'login.characters' => "����� ����� �������� ������ �� ���� �������� ��� ����������� ��������, ����, �������� '_',  '-' � �������.",
            'login.basic_rule' => "����� ����� ��������� �� 4 �� 20 ��������, � �������� ������ �� ���� �������� ��� ����������� ��������, ����, �������� '_',  '-' � �������. <br>����� �� ����� ���������� ��� ������������� �������� ��� �������� '_'.<br>����� � ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-' � ����� 1 �������, � ����� ����� 3-� ������ ���������� �������� ��� ����� 4-� ����!",

            'email.required' => '������� ��� email',
            'email.email' => '�������� ������ �����!',

            'psw.required' => '������� ������!',
            'psw.min' => '������ ������ ���� �� 6 ��������!',
            'psw.max' => '������ ������ ���� �� 20 ��������!',
            'psw2.same' => '������ �� ���������!',

            'sex.required' => '������� ��� ���!',
        ];


        static::registerRegistrationRules();

        $validator = \Validator::make(
            $params,
            [
                'login' => [
                    'bail',
                    'required',
                    'custom_min:4',
                    'custom_max:20',
                    'valid_login_klan',
                    'valid_deny_login',
                    'underscore',
                    'multi_underscore',
                    'same_characters',
                    'characters',
                    'basic_rule',
                    'unique:users,login'
                ],

                'email' => [
                    'bail',
                    'required',
                    'email',
                ],

                'sex' => [
                    'required',
                    'in:0,1',
                ],

                'psw' => [
                    'required',
                    'custom_min:6',
                    'custom_max:20',
                ],
                'psw2' => [
                    'required',
                    'custom_min:6',
                    'custom_max:20',
                    'same:psw'
                ],
            ],
            $messages
        );

        if ($validator->fails()) {
            throw new RegistrationException($validator->errors()->first());
        }

    }
}