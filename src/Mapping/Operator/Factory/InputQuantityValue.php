<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Bundle\DataImporterBundle\Mapping\Operator\Factory;

use Pimcore\Bundle\DataImporterBundle\Exception\InvalidConfigurationException;
use Pimcore\Bundle\DataImporterBundle\Mapping\Type\TransformationDataTypeService;
use Pimcore\Model\DataObject\Data\QuantityValue;

class InputQuantityValue extends QuantityValue
{
    /**
     * @param mixed $inputData
     * @param bool $dryRun
     *
     * @return QuantityValue
     */
    public function process($inputData, bool $dryRun = false)
    {
        return new \Pimcore\Model\DataObject\Data\QuantityValue(
            $inputData[0] ?? null,
            $inputData[1] ?? null
        );
    }

    /**
     * @param string $inputType
     * @param int|null $index
     *
     * @return string
     *
     * @throws InvalidConfigurationException
     */
    public function evaluateReturnType(string $inputType, int $index = null): string
    {
        if ($inputType !== TransformationDataTypeService::DEFAULT_ARRAY) {
            throw new InvalidConfigurationException(sprintf("Unsupported input type '%s' for input quantity value operator at transformation position %s", $inputType, $index));
        }

        return TransformationDataTypeService::INPUT_QUANTITY_VALUE;
    }

    /**
     * @param mixed $inputData
     *
     * @return string
     */
    public function generateResultPreview($inputData)
    {
        if ($inputData instanceof \Pimcore\Model\DataObject\Data\QuantityValue) {
            return 'InputQuantityValue: ' . $inputData->getValue() . ' ' . ($inputData->getUnit() ? $inputData->getUnit()->getAbbreviation() : '');
        }

        return $inputData;
    }
}
