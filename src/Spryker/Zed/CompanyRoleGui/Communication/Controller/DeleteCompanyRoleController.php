<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyRoleGui\Communication\Controller;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \Spryker\Zed\CompanyRoleGui\Communication\CompanyRoleGuiCommunicationFactory getFactory()
 */
class DeleteCompanyRoleController extends AbstractController
{
    /**
     * @var string
     */
    protected const PARAMETER_ID_COMPANY_ROLE = 'id-company-role';

    /**
     * @var string
     */
    protected const MESSAGE_DEFAULT_COMPANY_ROLE_DELETE_ERROR = 'You can not delete a default role, please set another default role before delete action';

    /**
     * @var string
     */
    protected const MESSAGE_COMPANY_ROLE_DELETE_SUCCESS = 'Company role has been successfully removed';

    /**
     * @var string
     */
    protected const MESSAGE_COMPANY_ROLE_DELETE_ERROR = 'Company role can not be removed';

    /**
     * @var string
     */
    protected const MESSAGE_COMPANY_ROLE_WITHOUT_ID_ERROR = 'No company role ID provided';

    /**
     * @var string
     */
    protected const PARAM_REFERER = 'referer';

    /**
     * @var string
     */
    protected const REDIRECT_URL_DEFAULT = '/company-role-gui/list-company-role';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $deleteForm = $this->getFactory()->createCompanyRoleDeleteForm()->handleRequest($request);

        if (!$deleteForm->isSubmitted() || !$deleteForm->isValid()) {
            $this->addErrorMessage('CSRF token is not valid');

            return $this->redirectResponse(static::REDIRECT_URL_DEFAULT);
        }

        $idCompanyRole = $request->query->getInt(static::PARAMETER_ID_COMPANY_ROLE);

        if (!$idCompanyRole) {
            throw new NotFoundHttpException(static::MESSAGE_COMPANY_ROLE_WITHOUT_ID_ERROR);
        }

        $companyRoleResponseTransfer = $this->getFactory()
            ->getCompanyRoleFacade()
            ->delete((new CompanyRoleTransfer())->setIdCompanyRole($idCompanyRole));

        if ($companyRoleResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::MESSAGE_COMPANY_ROLE_DELETE_SUCCESS);
        } else {
            $this->addErrorMessage(static::MESSAGE_COMPANY_ROLE_DELETE_ERROR);
        }

        return $this->redirectResponse(static::REDIRECT_URL_DEFAULT);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function confirmDeleteAction(Request $request)
    {
        $idCompanyRole = $request->query->getInt(static::PARAMETER_ID_COMPANY_ROLE);

        if (!$idCompanyRole) {
            throw new NotFoundHttpException(static::MESSAGE_COMPANY_ROLE_WITHOUT_ID_ERROR);
        }

        $companyRoleTransfer = $this->getFactory()
            ->getCompanyRoleFacade()
            ->getCompanyRoleById((new CompanyRoleTransfer())->setIdCompanyRole($idCompanyRole));

        if ($companyRoleTransfer->getIsDefault()) {
            $this->addErrorMessage(static::MESSAGE_DEFAULT_COMPANY_ROLE_DELETE_ERROR);

            return $this->redirectToReferer($request);
        }

        $deleteForm = $this->getFactory()->createCompanyRoleDeleteForm();

        return $this->viewResponse([
            'companyRoleTransfer' => $companyRoleTransfer,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToReferer(Request $request): RedirectResponse
    {
        return $this->redirectResponse(
            $request->headers->get(static::PARAM_REFERER, static::REDIRECT_URL_DEFAULT),
        );
    }
}
