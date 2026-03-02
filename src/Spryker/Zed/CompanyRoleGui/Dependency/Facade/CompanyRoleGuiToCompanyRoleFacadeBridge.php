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

class CompanyRoleGuiToCompanyRoleFacadeBridge implements CompanyRoleGuiToCompanyRoleFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct($companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    public function findDefaultCompanyRoleByIdCompany(int $idCompany): ?CompanyRoleTransfer
    {
        return $this->companyRoleFacade->findDefaultCompanyRoleByIdCompany($idCompany);
    }

    public function delete(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        return $this->companyRoleFacade->delete($companyRoleTransfer);
    }

    public function getCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleTransfer
    {
        return $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
    }

    public function create(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        return $this->companyRoleFacade->create($companyRoleTransfer);
    }

    public function update(CompanyRoleTransfer $companyRoleTransfer): void
    {
        $this->companyRoleFacade->update($companyRoleTransfer);
    }

    public function getCompanyRoleCollection(
        CompanyRoleCriteriaFilterTransfer $criteriaFilterTransfer
    ): CompanyRoleCollectionTransfer {
        return $this->companyRoleFacade->getCompanyRoleCollection($criteriaFilterTransfer);
    }

    public function findCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): ?CompanyRoleTransfer
    {
        return $this->companyRoleFacade->findCompanyRoleById($companyRoleTransfer);
    }

    /**
     * @param list<int> $companyUserIds
     *
     * @return array<int, list<string>>
     */
    public function getCompanyRoleNamesGroupedByCompanyUserIds(array $companyUserIds): array
    {
        return $this->companyRoleFacade->getCompanyRoleNamesGroupedByCompanyUserIds($companyUserIds);
    }
}
