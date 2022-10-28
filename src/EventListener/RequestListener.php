<?php
declare(strict_types=1);

namespace Tims3l\RestApi\EventListener;

use Spatie\Url\Url;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Tims3l\RestApi\AttributeHandler\ApiAttributeHandler;
use Tims3l\RestApi\Service\EntityService\EntityServiceInterface;
use Tims3l\RestApi\Service\RestApi\RestApiInterface;
use Tims3l\RestApi\Service\StrUtils;

#[AsEventListener(priority: 33)]
final class RequestListener
{
    private RequestEvent $event;
    
    public function __construct(
        private readonly EntityServiceInterface $entityService,
        private readonly ApiAttributeHandler $apiAttributeHandler, 
        private readonly RestApiInterface $api
    ) {}
    
    public function __invoke(RequestEvent $event): void
    {
        $this->event = $event;

        try {
            $uri = Url::fromString($this->event->getRequest()->getPathInfo());
            
            $this->api->setEntityClass(
                $this->getEntityClassByUriSegment(
                    $uri->getFirstSegment()
                )
            );

            $this->dispatch($uri);
            
        } catch (ResourceNotFoundException $e) {
            return;
        }
    }
    
    private function dispatch(Url $uri): void
    {
        if (is_numeric($id = $uri->getLastSegment())) {
            $response = match($this->event->getRequest()->getMethod()){
                Request::METHOD_GET => $this->api->show((int) $id),
                Request::METHOD_PUT => $this->api->update((int) $id),
                Request::METHOD_DELETE => $this->api->delete((int) $id),
            };
        } else {
            $response = match($this->event->getRequest()->getMethod()){
                Request::METHOD_GET => $this->api->index(),
                Request::METHOD_POST => $this->api->new(),
            };
        }

        $this->event->setResponse($response);
    }
    
    private function getEntityClassByUriSegment(string $uriSegment): string
    {
        foreach ($this->entityService->getAllEntityClassnames() as $class) {
            if (strtolower(StrUtils::getClassBasename($class)) == $uriSegment && $this->apiAttributeHandler->hasAttribute($class)) {
                return $class;
            }
        }
        
        throw new ResourceNotFoundException();
    }
}