<?php
/*
 * This file is part of Caviar.
 *
 * (c) 2014 Christoffer Niska
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace crisu83\yii_caviar\providers;

abstract class Provider extends \CComponent
{
    // Constants for built in providers.
    const COMPONENT = 'component';
    const CONTROLLER = 'controller';
    const CRUD = 'crud';
    const MODEL = 'model';
    const VIEW = 'view';

    /**
     * @var string
     */
    public $name = 'base';

    /**
     * @return array map of the data provided.
     */
    abstract public function provide();
}