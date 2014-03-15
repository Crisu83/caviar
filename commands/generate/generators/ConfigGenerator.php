<?php
/*
 * This file is part of yii-caviar.
 *
 * (c) 2014 Christoffer Niska
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace console\commands\generate\generators;

class ConfigGenerator extends ViewGenerator
{
    /**
     * @var string
     */
    public $name = 'config';

    /**
     * @var string
     */
    public $description = 'Configuration file generator.';

    /**
     * @var string
     */
    public $fileName = 'config.php';

    /**
     * @var string
     */
    public $filePath = 'config';
}