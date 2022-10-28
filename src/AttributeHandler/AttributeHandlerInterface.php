<?php
declare(strict_types=1);

namespace Tims3l\RestApi\AttributeHandler;

interface AttributeHandlerInterface
{
    public function hasAttribute(string $class): bool;
}
