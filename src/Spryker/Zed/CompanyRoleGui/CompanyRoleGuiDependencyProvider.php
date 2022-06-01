<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui;

use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyFacadeBridge;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToCompanyRoleFacadeBridge;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToGlossaryFacadeBridge;
use Spryker\Zed\CompanyRoleGui\Dependency\Facade\CompanyRoleGuiToPermissionFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CompanyRoleGui\CompanyRoleGuiConfig getConfig()
 */
class CompanyRoleGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY = 'FACADE_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_ROLE = 'PROPEL_QUERY_COMPANY_ROLE';

    /**
     * @var string
     */
    public const FACADE_GLOSSARY = 'FACADE_GLOSSARY';

    /**
     * @var string
     */
    public const FACADE_PERMISSION = 'FACADE_PERMISSION';

    /**
     * @var string
     */
    public const PLUGINS_COMPANY_ROLE_CREATE_FORM_EXPANDER = 'PLUGINS_COMPANY_ROLE_CREATE_FORM_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addCompanyFacade($container);
        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addCompanyRolePropelQuery($container);
        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addGlossaryFacade($container);
        $container = $this->addPermissionFacade($container);
        $container = $this->addCompanyRoleCreateFormExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY, function (Container $container) {
            return new CompanyRoleGuiToCompanyFacadeBridge(
                $container->getLocator()->company()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_ROLE, function (Container $container) {
            return new CompanyRoleGuiToCompanyRoleFacadeBridge(
                $container->getLocator()->companyRole()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRolePropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_COMPANY_ROLE, $container->factory(function () {
            return SpyCompanyRoleQuery::create();
        }));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGlossaryFacade(Container $container): Container
    {
        $container->set(static::FACADE_GLOSSARY, function (Container $container) {
            return new CompanyRoleGuiToGlossaryFacadeBridge(
                $container->getLocator()->glossary()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionFacade(Container $container): Container
    {
        $container->set(static::FACADE_PERMISSION, function (Container $container) {
            return new CompanyRoleGuiToPermissionFacadeBridge(
                $container->getLocator()->permission()->facade(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleCreateFormExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_COMPANY_ROLE_CREATE_FORM_EXPANDER, function () {
            return $this->getCompanyRoleCreateFormExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CompanyRoleGuiExtension\Communication\Plugin\CompanyRoleCreateFormExpanderPluginInterface>
     */
    protected function getCompanyRoleCreateFormExpanderPlugins(): array
    {
        return [];
    }
}
