<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyUserRoleByCompany\DataProvider;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyUserRoleByCompany\CompanyUserRoleByCompanyForm;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyRoleFacadeInterface;

class CompanyUserRoleByCompanyFormDataProvider
{
    /**
     * @var \Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    public function __construct(CompanyRoleGuiToCompanyRoleFacadeInterface $companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    public function getData(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        $defaultCompanyRole = $this->companyRoleFacade->findDefaultCompanyRoleByIdCompany($companyUserTransfer->getCompany()->getIdCompany());
        $companyRoleCollectionWithDefaultCompanyRole = (new CompanyRoleCollectionTransfer())
            ->addRole($defaultCompanyRole);

        $companyUserTransfer->setCompanyRoleCollection($companyRoleCollectionWithDefaultCompanyRole);

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array<string, mixed>
     */
    public function getOptions(CompanyUserTransfer $companyUserTransfer): array
    {
        return [
            CompanyUserRoleByCompanyForm::OPTION_COMPANY_ROLE_CHOICES =>
                $this->getCompanyRoleChoices($companyUserTransfer),
        ];
    }

    protected function getCompanyRoleChoices(CompanyUserTransfer $companyUserTransfer): array
    {
        $companyRoleChoicesValues = [];

        $companyRoleCollection = $this->companyRoleFacade->getCompanyRoleCollection(
            (new CompanyRoleCriteriaFilterTransfer())->setIdCompany($companyUserTransfer->getCompany()->getIdCompany()),
        );

        foreach ($companyRoleCollection->getRoles() as $companyRoleTransfer) {
            $roleName = $this->generateCompanyRoleName($companyRoleTransfer);
            $companyRoleChoicesValues[$roleName] = $companyRoleTransfer->getIdCompanyRole();
        }

        return $companyRoleChoicesValues;
    }

    protected function generateCompanyRoleName(CompanyRoleTransfer $companyRoleTransfer): string
    {
        return sprintf('%s (id: %s)', $companyRoleTransfer->getName(), $companyRoleTransfer->getIdCompanyRole());
    }
}
