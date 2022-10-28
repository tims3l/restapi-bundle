<?php
declare(strict_types=1);

namespace Tims3l\RestApi\AttributeHandler;

abstract class AbstractAttributeHandler implements AttributeHandlerInterface {

    protected const HANDLER_CLASS = '';

    public function hasAttribute(string $class): bool
    {
        foreach ((new \ReflectionClass($class))->getAttributes() as $attribute) {
            if ($attribute->getName() == static::HANDLER_CLASS) {
                return true;
            }
        }

        return false;
    }
}
