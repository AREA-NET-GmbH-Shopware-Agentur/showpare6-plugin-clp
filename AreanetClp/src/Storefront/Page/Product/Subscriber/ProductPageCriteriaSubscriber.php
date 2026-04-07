<?php declare(strict_types=1);

namespace AreanetClp\Storefront\Page\Product\Subscriber;

use Shopware\Core\Content\Product\Events\ProductListingCriteriaEvent;
use Shopware\Core\Content\Product\ProductEvents;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Shopware\Storefront\Page\Product\ProductPageCriteriaEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ProductPageCriteriaSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageCriteriaEvent::class => 'onProductCriteriaLoaded',
            ProductEvents::PRODUCT_LISTING_CRITERIA => 'onProductListingCriteria',
        ];
    }

    public function onProductCriteriaLoaded(ProductPageCriteriaEvent $event): void
    {
        $event->getCriteria()->addAssociation('areanetClp');
        $event->getCriteria()->addAssociation('areanetClp.ghs');
    }

    public function onProductListingCriteria(ProductListingCriteriaEvent $event) {
        $event->getCriteria()->addAssociation('areanetClp');
    }
}
