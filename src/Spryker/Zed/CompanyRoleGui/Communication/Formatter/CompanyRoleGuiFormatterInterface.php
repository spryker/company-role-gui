<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication\Formatter;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;

/**
 * @deprecated Covered in \Spryker\Zed\CompanyRoleGui\Communication\Expander\CompanyRoleCompanyUserTableDataExpanderInterface
 */
interface CompanyRoleGuiFormatterInterface
{
    public function formatCompanyRoleNames(CompanyRoleCollectionTransfer $companyRoleCollectionTransfer): string;
}
