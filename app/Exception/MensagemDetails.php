<?php

namespace Catalog\Exception;

class MensagemDetails
{
    public int $statusCode;
    public string $alertInfo;
    public string $mensagem;

    public function __construct(int $statusCode, string $alertInfo, string $mensagem)
    {
        $this->statusCode = $statusCode;
        $this->alertInfo = $alertInfo;
        $this->mensagem = $mensagem;
    }
}
