<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication\Expander;

use Spryker\Zed\CompanyRoleGui\CompanyRoleGuiConfig;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyRoleFacadeInterface;

class CompanyRoleCompanyUserTableDataExpander implements CompanyRoleCompanyUserTableDataExpanderInterface
{
    public function __construct(protected CompanyRoleGuiToCompanyRoleFacadeInterface $companyRoleFacade)
    {
    }

    /**
     * @param list<array<string, mixed>> $companyUserDataTableRows
     *
     * @return list<array<string, mixed>>
     */
    public function expandCompanyUserTableDataWithCompanyRoles(array $companyUserDataTableRows): array
    {
        $companyUserIds = $this->extractCompanyUserIds($companyUserDataTableRows);

        if ($companyUserIds === []) {
            return $companyUserDataTableRows;
        }

        $companyRoleNamesByCompanyUserId = $this->companyRoleFacade
            ->getCompanyRoleNamesGroupedByCompanyUserIds($companyUserIds);

        foreach ($companyUserDataTableRows as $index => $companyUserDataItem) {
            $idCompanyUser = $companyUserDataItem[CompanyRoleGuiConfig::COL_ID_COMPANY_USER];
            $roleNames = $companyRoleNamesByCompanyUserId[$idCompanyUser] ?? [];

            $companyUserDataTableRows[$index][CompanyRoleGuiConfig::COL_COMPANY_ROLE_NAMES] =
                $this->formatCompanyRoleNames($roleNames);
        }

        return $companyUserDataTableRows;
    }

    /**
     * @param list<array<string, mixed>> $companyUserDataTableRows
     *
     * @return list<int>
     */
    protected function extractCompanyUserIds(array $companyUserDataTableRows): array
    {
        $companyUserIds = [];

        foreach ($companyUserDataTableRows as $companyUserDataItem) {
            $companyUserIds[] = $companyUserDataItem[CompanyRoleGuiConfig::COL_ID_COMPANY_USER];
        }

        return $companyUserIds;
    }

    /**
     * @param list<string> $roleNames
     *
     * @return string
     */
    protected function formatCompanyRoleNames(array $roleNames): string
    {
        $formattedRoles = [];

        foreach ($roleNames as $roleName) {
            $formattedRoles[] = '<p>' . htmlspecialchars($roleName) . '</p>';
        }

        return implode('', $formattedRoles);
    }
}
