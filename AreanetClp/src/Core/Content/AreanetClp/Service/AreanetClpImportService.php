<?php
namespace AreanetClp\Core\Content\AreanetClp\Service;

use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\Language\LanguageCollection;

class AreanetClpImportService
{
    private EntityRepository $languageRepository;
    private EntityRepository $clpRepository;
    private EntityRepository $clpGhsRepository;

    public function __construct(
        EntityRepository $languageRepository,
        EntityRepository $clpRepository,
        EntityRepository $clpGhsRepository,
    )
    {
        $this->languageRepository = $languageRepository;
        $this->clpRepository = $clpRepository;
        $this->clpGhsRepository = $clpGhsRepository;
    }

    public function import() {
        $dataFolder = __DIR__ . '/../../../../Resources/data/';
        $languages = $this->getLanguages();

        $insertData = [];
        $insertGhsData = [];

        $clpGhsFolder = "ghs/";

        $clpData = [
            "euh/",
            "h/",
            "p/"
        ];

        foreach ($languages as $language) {
            if (file_exists($dataFolder . $clpGhsFolder . $language->getLocale()->getCode() . '.csv')) {
                $file = \file_get_contents($dataFolder . $clpGhsFolder . $language->getLocale()->getCode() . '.csv');
            } else {
                $file = \file_get_contents($dataFolder . $clpGhsFolder . 'en-GB.csv');
            }

            $lines = str_getcsv($file, "\n");
            foreach ($lines as $fields) {
                $fields = str_getcsv($fields, ';');

                if (!array_key_exists($fields[0], $insertGhsData)) {
                    $insertGhsData[$fields[0]] = [
                        'id' => md5($fields[0]),
                        'name' => $fields[0],
                        'image' => strtolower($fields[0]).".svg",
                        'translations' => [],
                    ];
                }

                $insertGhsData[$fields[0]]['translations'][$language->getId()] = [
                    'text' => $fields[1]
                ];

                if (!array_key_exists(Defaults::LANGUAGE_SYSTEM, $insertGhsData[$fields[0]]['translations'])) {
                    $insertGhsData[$fields[0]]['translations'][Defaults::LANGUAGE_SYSTEM] = [
                        'text' => $fields[1]
                    ];
                }
            }
        }

        foreach ($languages as $language) {
            foreach($clpData as $clpFolder) {
                if (file_exists($dataFolder . $clpFolder . $language->getLocale()->getCode() . '.csv')) {
                    $file = \file_get_contents($dataFolder . $clpFolder . $language->getLocale()->getCode() . '.csv');
                } else {
                    $file = \file_get_contents($dataFolder . $clpFolder . 'en-GB.csv');
                }

                $lines = str_getcsv($file, "\n");
                foreach ($lines as $fields) {
                    $fields = str_getcsv($fields, ';');

                    if (!array_key_exists($fields[0], $insertData)) {
                        $type = $this->getTypeByName($fields[0]);

                        $insertData[$fields[0]] = [
                            'id' => md5($fields[0]),
                            'type' => $type,
                            'ghsId' => isset($fields[3]) ? md5($fields[3]) : null,
                            'imported' => true,
                            'translations' => []
                        ];

                        if(!empty($fields[2])) $insertData[$fields[0]]['signalName'] = $fields[2];
                    }

                    $insertData[$fields[0]]['translations'][$language->getId()] = [
                        'name' => $fields[0],
                        'text' => $fields[1]
                    ];

                    if (!array_key_exists(Defaults::LANGUAGE_SYSTEM, $insertData[$fields[0]]['translations'])) {
                        $insertData[$fields[0]]['translations'][Defaults::LANGUAGE_SYSTEM] = [
                            'name' => $fields[0],
                            'text' => $fields[1]
                        ];
                    }
                }
            }
        }

        $this->clpGhsRepository->upsert(array_values($insertGhsData), Context::createDefaultContext());
        $this->clpRepository->upsert(array_values($insertData), Context::createDefaultContext());
    }

    private function getTypeByName($name) {
        $lowerName = strtolower($name);

        if(substr($lowerName, 0, 3) === 'euh') {
            return 'areanet_clp_euh';
        }
        if(substr($lowerName, 0, 1) === 'h') {
            return 'areanet_clp_h';
        }
        if(substr($lowerName, 0, 1) === 'p') {
            return 'areanet_clp_p';
        }

        return 'unknown';
    }

    private function getLanguages(): LanguageCollection
    {
        $criteria = new Criteria();
        $criteria->addAssociation('locale');
        $result = $this->languageRepository->search($criteria, Context::createDefaultContext());

        return $result->getEntities();
    }
}
