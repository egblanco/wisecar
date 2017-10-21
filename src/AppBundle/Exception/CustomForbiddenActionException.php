<?php

/*
 * This file is part of the EasyAdminBundle.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Exception;

class CustomForbiddenActionException extends \RuntimeException
{
    public function __construct($errorMessage)
    {
        parent::__construct($errorMessage);
    }
}
