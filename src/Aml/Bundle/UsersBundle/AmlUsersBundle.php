<?php

namespace Aml\Bundle\UsersBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AmlUsersBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
