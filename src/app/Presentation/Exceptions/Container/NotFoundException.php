<?php

declare(strict_types=1);

namespace App\Presentation\Exceptions\Container;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface {}
