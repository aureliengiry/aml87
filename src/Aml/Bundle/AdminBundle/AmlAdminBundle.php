<?php

namespace Aml\Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AmlAdminBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataAdminBundle';
    }

}
