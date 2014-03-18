<?php
/*
 * This file is part of Caviar.
 *
 * (c) 2014 Christoffer Niska
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace crisu83\yii_caviar\generators;

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
    public $defaultTemplate = 'config.txt';

    /**
     * @var string
     */
    public $fileName = 'config.php';

    /**
     * @var string
     */
    public $filePath = 'config';
}