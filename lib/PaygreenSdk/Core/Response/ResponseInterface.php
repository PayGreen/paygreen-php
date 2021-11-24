<?php

namespace Paygreen\Sdk\Core\Response;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

interface ResponseInterface
{
    public function __construct(PsrResponseInterface $response);

    /**
     * @return array<string>|string
     */
    public function getData();

    /**
     * @return array<string>
     */
    public function toArray();
}
