<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Spryker\Zed\CompanyRoleGui\Communication\Expander\CompanyRoleCompanyUserTableDataExpander;
use Spryker\Zed\CompanyRoleGui\Communication\Expander\CompanyRoleCompanyUserTableDataExpanderInterface;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyRoleCreateForm;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyRoleDeleteForm;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyRoleEditForm;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyUserRoleByCompany\CompanyUserRoleByCompanyForm;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyUserRoleByCompany\DataProvider\CompanyUserRoleByCompanyFormDataProvider;
use Spryker\Zed\CompanyRoleGui\Communication\Form\CompanyUserRoleForm;
use Spryker\Zed\CompanyRoleGui\Communication\Form\DataProvider\CompanyRoleCreateDataProvider;
use Spryker\Zed\CompanyRoleGui\Communication\Form\DataProvider\CompanyUserRoleFormDataProvider;
use Spryker\Zed\CompanyRoleGui\Communication\Formatter\CompanyRoleGuiFormatter;
use Spryker\Zed\CompanyRoleGui\Communication\Formatter\CompanyRoleGuiFormatterInterface;
use Spryker\Zed\CompanyRoleGui\Communication\Table\CompanyRoleTable;
use Spryker\Zed\CompanyRoleGui\CompanyRoleGuiDependencyProvider;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyFacadeInterface;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyRoleFacadeInterface;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToGlossaryFacadeInterface;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @method \Spryker\Zed\CompanyRoleGui\CompanyRoleGuiConfig getConfig()
 */
class CompanyRoleGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createCompanyUserRoleForm(): FormTypeInterface
    {
        return new CompanyUserRoleForm();
    }

    public function createCompanyUserRoleFormDataProvider(): CompanyUserRoleFormDataProvider
    {
        return new CompanyUserRoleFormDataProvider($this->getCompanyRoleFacade());
    }

    public function createCompanyUserRoleAutoSuggestForm(CompanyUserTransfer $companyUserTransfer): FormInterface
    {
        $dataProvider = $this->createCompanyUserRoleFormDataProvider();

        return $this->getFormFactory()->create(
            CompanyUserRoleForm::class,
            $companyUserTransfer,
            $dataProvider->getOptions($companyUserTransfer),
        );
    }

    public function getCompanyRoleFacade(): CompanyRoleGuiToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::FACADE_COMPANY_ROLE);
    }

    public function createCompanyRoleTable(): CompanyRoleTable
    {
        return new CompanyRoleTable(
            $this->getCompanyRolePropelQuery(),
        );
    }

    public function createCompanyRoleGuiFormatter(): CompanyRoleGuiFormatterInterface
    {
        return new CompanyRoleGuiFormatter();
    }

    public function createCompanyRoleCompanyUserTableDataExpander(): CompanyRoleCompanyUserTableDataExpanderInterface
    {
        return new CompanyRoleCompanyUserTableDataExpander($this->getCompanyRoleFacade());
    }

    public function getCompanyRolePropelQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }

    public function createCompanyRoleCreateForm(): FormInterface
    {
        $dataProvider = $this->createCompanyRoleCreateFormDataProvider();

        return $this->getFormFactory()->create(
            CompanyRoleCreateForm::class,
            $dataProvider->getData(),
            $dataProvider->getOptions(),
        );
    }

    public function createCompanyRoleEditForm(CompanyRoleTransfer $companyRoleTransfer): FormInterface
    {
        $dataProvider = $this->createCompanyRoleCreateFormDataProvider();

        return $this->getFormFactory()->create(
            CompanyRoleEditForm::class,
            $dataProvider->getData($companyRoleTransfer),
            $dataProvider->getOptions(),
        );
    }

    public function createCompanyRoleDeleteForm(): FormInterface
    {
        return $this->getFormFactory()->create(CompanyRoleDeleteForm::class);
    }

    public function createCompanyRoleCreateFormDataProvider(): CompanyRoleCreateDataProvider
    {
        return new CompanyRoleCreateDataProvider(
            $this->getCompanyFacade(),
            $this->getCompanyRoleFacade(),
            $this->getGlossaryFacade(),
            $this->getPermissionFacade(),
        );
    }

    public function getCompanyFacade(): CompanyRoleGuiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::FACADE_COMPANY);
    }

    public function getGlossaryFacade(): CompanyRoleGuiToGlossaryFacadeInterface
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::FACADE_GLOSSARY);
    }

    public function getPermissionFacade(): CompanyRoleGuiToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::FACADE_PERMISSION);
    }

    public function createCompanyUserRoleByCompanyForm(): FormTypeInterface
    {
        return new CompanyUserRoleByCompanyForm();
    }

    public function createCompanyUserRoleFormDataProviderByCompany(): CompanyUserRoleByCompanyFormDataProvider
    {
        return new CompanyUserRoleByCompanyFormDataProvider($this->getCompanyRoleFacade());
    }

    /**
     * @return array<\Spryker\Zed\CompanyRoleGuiExtension\Communication\Plugin\CompanyRoleCreateFormExpanderPluginInterface>
     */
    public function getCompanyRoleCreateFormExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyRoleGuiDependencyProvider::PLUGINS_COMPANY_ROLE_CREATE_FORM_EXPANDER);
    }
}
