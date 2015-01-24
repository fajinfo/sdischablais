<?php

namespace Jsp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JspUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
