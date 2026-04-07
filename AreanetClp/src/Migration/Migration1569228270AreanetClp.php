<?php declare(strict_types=1);

namespace AreanetClp\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\{InheritanceUpdaterTrait, MigrationStep};


class Migration1569228270AreanetClp extends MigrationStep {

    use InheritanceUpdaterTrait;

    public function getCreationTimestamp(): int
    {
        return 1569228270;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS `areanet_clp_ghs` (
                `id` BINARY(16) NOT NULL,
                `name` VARCHAR(40) NOT NULL,
                `image` VARCHAR(40) NOT NULL default '',
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `areanet_clp_ghs_translation` (
                `areanet_clp_ghs_id` BINARY(16) NOT NULL,
                `language_id` BINARY(16) NOT NULL,
                `text` VARCHAR(1000),
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`areanet_clp_ghs_id`, `language_id`),
                CONSTRAINT `fk.properties_translations.areanet_clp_ghs_id` 
                    FOREIGN KEY (`areanet_clp_ghs_id`)
                    REFERENCES `areanet_clp_ghs` (`id`) 
                        ON DELETE CASCADE 
                        ON UPDATE CASCADE,
                CONSTRAINT `fk.properties_translations.language_clp_ghs_id` 
                    FOREIGN KEY (`language_id`)
                    REFERENCES `language` (`id`) 
                        ON DELETE CASCADE 
                        ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS `areanet_clp` (
                `id` BINARY(16) NOT NULL,
                `type` VARCHAR(40) NOT NULL,
                `signal_name` VARCHAR(40) NOT NULL default '',
                `imported` INT(1) NOT NULL default 0,
                `areanet_clp_ghs_id` binary(16) NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.areanet_clp.areanet_clp_ghs_id`
                    FOREIGN KEY (`areanet_clp_ghs_id`)
                    REFERENCES `areanet_clp_ghs` (`id`)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `areanet_clp_translation` (
                `areanet_clp_id` BINARY(16) NOT NULL,
                `language_id` BINARY(16) NOT NULL,
                `text` VARCHAR(1000),
                `name` VARCHAR(1000),
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`areanet_clp_id`, `language_id`),
                CONSTRAINT `fk.properties_translations.areanet_clp_id` 
                    FOREIGN KEY (`areanet_clp_id`)
                    REFERENCES `areanet_clp` (`id`) 
                        ON DELETE CASCADE 
                        ON UPDATE CASCADE,
                CONSTRAINT `fk.properties_translations.language_clp_id` 
                    FOREIGN KEY (`language_id`)
                    REFERENCES `language` (`id`) 
                        ON DELETE CASCADE 
                        ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS  `areanet_clp_product` (
                `areanet_clp_id` BINARY(16) NOT NULL,
                `product_id` BINARY(16) NOT NULL,
                `product_version_id` BINARY(16) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`areanet_clp_id`, `product_id`, `product_version_id`),
                CONSTRAINT `fk.products_properties.areanet_clp_id`
                    FOREIGN KEY (`areanet_clp_id`)
                    REFERENCES `areanet_clp` (`id`)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE,
                CONSTRAINT `fk.product_clp.product_clp_id__product_version_id`
                    FOREIGN KEY (`product_id`, `product_version_id`)
                    REFERENCES `product` (`id`, `version_id`)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->updateInheritance($connection, 'product', 'areanetClp');
    }

    public function updateDestructive(Connection $connection): void
    {
        // Nothing
    }


}
