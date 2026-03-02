<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyRoleGuiToCompanyRoleFacadeInterface
{
    public function findDefaultCompanyRoleByIdCompany(int $idCompany): ?CompanyRoleTransfer;

    public function delete(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer;

    public function getCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleTransfer;

    public function create(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer;

    public function update(CompanyRoleTransfer $companyRoleTransfer): void;

    public function getCompanyRoleCollection(
        CompanyRoleCriteriaFilterTransfer $criteriaFilterTransfer
    ): CompanyRoleCollectionTransfer;

    public function findCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): ?CompanyRoleTransfer;

    /**
     * @param list<int> $companyUserIds
     *
     * @return array<int, list<string>>
     */
    public function getCompanyRoleNamesGroupedByCompanyUserIds(array $companyUserIds): array;
}
