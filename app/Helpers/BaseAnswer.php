<?php

namespace App\Helpers;


use App\Services\Contracts\ToObject;
use App\Services\Contracts\ToArray;
use App\Services\Contracts\ToJson;

class BaseAnswer implements ToArray, ToJson, ToObject
{
    public $fields = [];
    public $message;
    public $status;
    public $data;

    static $instance;

    /**
     * sets the given array or the given values to the related
     * properties and <fields> related indexes.
     *
     * BaseAnswer constructor.
     * @param null $status
     * @param null $data
     * @param null $message
     */
    public function __construct($data = null, $status = null, $message = null)
    {
        if (is_array($data)) {
            $this->status = $this->fields['status'] = $data['status'];
            $this->data = $this->fields['data'] = $data['data'];
            $this->message = $this->fields['message'] = $data['message'];
        }

        $this->status = $this->fields['status'] = $status;
        $this->data = $this->fields['data'] = $data;
        $this->message = $this->fields['message'] = $message;
    }

    public static function getInstance()
    {
        static::$instance = new static;

        return static::$instance;
    }

    public function setAll($data)
    {
        $this->status = $this->fields['status'] = $data['status'];
        $this->data = $this->fields['data'] = $data['data'];
        $this->message = $this->fields['message'] = $data['message'];

        return $this;
    }

    /**
     * sets the <message> property and <fields['message']> at the same
     * time to the passed value
     *
     * @param $message
     * @return BaseAnswer
     */
    public function setMessage($message)
    {
        $this->message = $this->fields['message'] = $message;

        return $this;
    }

    /**
     * sets the <data> property and <fields['data']> at the same
     * time to the passed value
     *
     * @param $data
     * @return BaseAnswer
     */
    public function setData($data)
    {
        $this->data = $this->fields['data'] = $data;

        return $this;
    }

    /**
     * sets the <status> property and <fields['status']> at the same
     * time to the passed value
     *
     * @param $status
     * @return BaseAnswer
     */
    public function setStatus($status)
    {
        $this->status = $this->fields['status'] = $status;

        return $this;
    }

    /**
     * return the <message> property of the class
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * return the <data> property of the class
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * return the <status> property of the class
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Checks for the requested property in the class and
     * if there is not such a property in the class, it
     * will returns the property that exists in the
     * <fields> property and if there is no such
     * index in the <fields> property, It will
     * return null with an error message.
     *
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    // public function __set($name, $value)
    // {
    //     $this->$name = $this->fields[$name] = $value;
    // }

    /**
     * returns The whole properties in array
     *
     * @example $returnedData['message'], $returnedData['status'], $returnedData['data']
     * @return array
     */
    public function toArray(): array
    {
        return $this->fields;
    }

    public function toJson()
    {
        return json_encode($this->fields);
    }

    /**
     * returns The whole properties in object.
     *
     * @example $this->message, $this->status, $this->data
     * @return array
     */
    public function toObject(): object
    {
        return $this;
    }
}
