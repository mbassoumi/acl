<?php


namespace Souktel\ACL\Exceptions;


use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class InvalidPayloadException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        parent::report($this);
    }

    public function render($request)
    {
        $message = !empty($this->getMessage()) ? $this->getMessage() : 'Wrong Payload form Auth Service';

        return response()->json(['message' => $message], Response::HTTP_FORBIDDEN);
    }
}
