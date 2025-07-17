<?php

declare(strict_types=1);

/*
 * This file is part of Webmail.
 *
 * (c) Andreas Steinkellner 2024 <a-steinkellner@outlook.com>
 * @license LGPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/m-werk/webmail
 */

namespace MWerk\Webmail;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MWerkWebmail extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
