<?php declare(strict_types=1);

namespace AreanetClp;

use AreanetClp\Core\Content\AreanetClp\Service\AreanetClpImportService;
use Doctrine\DBAL\Connection;
use Exception;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;

class AreanetClp extends Plugin
{
    public function install(InstallContext $installContext): void
    {

    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if (!$uninstallContext->keepUserData()) {
            $connection = $this->container->get(Connection::class);

            try {
                $connection->executeStatement('ALTER TABLE `product` DROP COLUMN `areanetClp`');
            } catch(Exception $e) {
                echo "Column \"clp\" on \"product\" not deleted.\n\r";
            }

            $tablesToDelete = [
                'areanet_clp_product',
                'areanet_clp_translation',
                'areanet_clp',
                'areanet_clp_ghs_translation',
                'areanet_clp_ghs',
            ];

            foreach ($tablesToDelete as $table) {
                try {
                    $connection->executeStatement('DROP TABLE IF EXISTS `' . $table . '`');
                } catch(Exception $e) {
                    echo "Table \"" . $table . "\" not deleted.\n\r";
                }
            }

            $this->removeCustomFieldValues();
        }
    }

    public function activate(ActivateContext $activateContext): void
    {
        $areanetClpImportService = $this->container->get(AreanetClpImportService::class);
        $areanetClpImportService->import();
    }

    public function deactivate(DeactivateContext $deactivateContext): void
    {

    }

    public function update(UpdateContext $updateContext): void
    {

    }

    public function postInstall(InstallContext $installContext): void
    {
    }

    public function postUpdate(UpdateContext $updateContext): void
    {
        if($this->container->has(AreanetClpImportService::class)) {
            $areanetClpImportService = $this->container->get(AreanetClpImportService::class);
            $areanetClpImportService->import();
        }
    }

    private function removeCustomFieldValues(): void
    {
        $productRepository = $this->container->get('product.repository');
        $context = Context::createDefaultContext();

        $criteria = new Criteria();
        $criteria->addFilter(new NotFilter(
            MultiFilter::CONNECTION_AND,
            [new EqualsFilter('customFields', null)]
        ));

        $products = $productRepository->search($criteria, $context);

        $resetCustomFields = [];
        $setCustomFields = [];

        foreach ($products as $product) {
            $customFields = $product->getCustomFields();
            $keys = array_keys($customFields);
            if (in_array('areanet_clp', $keys)) {
                unset($customFields['areanet_clp']);
                $resetCustomFields[] = [
                    'id' => $product->getId(),
                    'customFields' => []
                ];
                $setCustomFields[] = [
                    'id' => $product->getId(),
                    'customFields' => $customFields
                ];
            }
        }

        $productRepository->upsert($resetCustomFields, $context);
        $productRepository->upsert($setCustomFields, $context);
    }
}
