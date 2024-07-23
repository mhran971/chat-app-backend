<?php


namespace App\Requests;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseRequestFormApi
{
    protected $_request;

    private $status = false;

    private $errors = [];

    protected $validatedData = [];


    abstract public function rules(): array;

    /**
     * @throws Exception
     */
    public function __construct(Request $request = null)
    {
        if (!is_null($request)) {
            $this->_request = $request;
            $rules = $this->rules();
            $validator = Validator::make(
                $this->_request->all(),
                $rules
            );

            if ($validator->fails()) {
                // Set status to true if validation fails
                $this->status = true;
                // Assign errors here
                $this->errors = $validator->errors()->getMessages();
            } else {
                $this->validatedData = $validator->validated();
                //$this->validatedData = $this->request()->all();
            }
        }
    }

    public function request()
    {
        return $this->_request;
    }


    public function hasError(): bool
    {
        return $this->status;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function has($key): bool
    {
        return $this->_request->has($key);
    }

    public function validatedData()
    {
        return $this->validatedData;
    }
}
