<?php namespace App\Exceptions;

use Illuminate\Support\MessageBag;
use Response;

class ValidationException extends RepositoryException
{
    protected $messageBag;

    public function __construct(MessageBag $messageBag)
    {
        parent::__construct('Validation failed', RepositoryException::VALIDATION_FAILED);

        $this->messageBag = clone($messageBag);
    }

    public function getMessageBag()
    {
        return clone($this->messageBag);
    }
}
