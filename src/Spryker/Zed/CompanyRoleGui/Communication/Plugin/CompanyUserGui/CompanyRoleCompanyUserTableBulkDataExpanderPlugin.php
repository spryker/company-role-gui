<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication\Plugin\CompanyUserGui;

use Spryker\Zed\CompanyUserGuiExtension\Dependency\Plugin\CompanyUserTableBulkDataExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\CompanyRoleGui\Communication\CompanyRoleGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CompanyRoleGui\CompanyRoleGuiConfig getConfig()
 */
class CompanyRoleCompanyUserTableBulkDataExpanderPlugin extends AbstractPlugin implements CompanyUserTableBulkDataExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands table data rows of company user table with company role names.
     * - Fetches all company roles in bulk for better performance.
     *
     * @api
     *
     * @param list<array<string, mixed>> $companyUserDataTableRows
     *
     * @return list<array<string, mixed>>
     */
    public function expandData(array $companyUserDataTableRows): array
    {
        return $this->getFactory()
            ->createCompanyRoleCompanyUserTableDataExpander()
            ->expandCompanyUserTableDataWithCompanyRoles($companyUserDataTableRows);
    }
}
