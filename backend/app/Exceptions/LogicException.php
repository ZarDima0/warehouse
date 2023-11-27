<?php

namespace App\Exceptions;

class LogicException extends \Exception
{
    protected $message = 'Произошла внутренняя ошибка.';

    protected array $errors = [];

    public function __construct(string $message = '', array $errors = [])
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
