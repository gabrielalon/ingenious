<?php

namespace App\Infrastructure\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class NotFoundException extends BaseException
{
    protected $code = Response::HTTP_NOT_FOUND;
    protected $message = 'The requested Resource was not found.';
}
