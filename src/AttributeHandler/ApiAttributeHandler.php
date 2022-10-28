<?php
declare(strict_types=1);

namespace Tims3l\RestApi\AttributeHandler;

use Tims3l\RestApi\Attribute\Api;

class ApiAttributeHandler extends AbstractAttributeHandler
{
    protected const HANDLER_CLASS = Api::class;
}