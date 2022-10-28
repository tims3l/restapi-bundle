<?php
declare(strict_types=1);

namespace Tims3l\RestApi\Service\RestApi;

use Symfony\Component\HttpFoundation\JsonResponse;

interface RestApiInterface
{
    public function index(): JsonResponse;

    public function show(int $id): JsonResponse;

    public function new(): JsonResponse;

    public function update(int $id): JsonResponse;
    
    public function delete(int $id): JsonResponse;
}
