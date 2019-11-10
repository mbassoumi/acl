<?php


namespace Souktel\ACL\Exceptions;


use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class InvalidPayloadException extends Exception
{

    public function render($request)
    {
        $message = !empty($this->getMessage()) ? $this->getMessage() : 'Wrong Payload form Auth Service';

        return response()->json(['message' => $message], Response::HTTP_FORBIDDEN);
    }
}
