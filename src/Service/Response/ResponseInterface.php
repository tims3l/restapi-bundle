<?php
declare(strict_types=1);

namespace Tims3l\RestApi\Service\Response;

interface ResponseInterface {
    
    public function jsonSerialize(): array;
}
