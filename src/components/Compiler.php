<?php
/*
 * This file is part of Caviar.
 *
 * (c) 2014 Christoffer Niska
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace crisu83\yii_caviar\components;

class Compiler extends \CComponent
{
    /**
     * Compiles a template using the given data.
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function compile($template, $data)
    {
        foreach ($data as $key => $value) {
            // TODO refactor code so that we do not need this check
            if (!is_string($value)) {
                continue;
            }

            $template = preg_replace("/\\$$key\\$/i", $value, $template);
        }

        return preg_replace('/(<?php)/', "$1\n" . $this->renderBanner(), $template, 1);
    }

    /**
     * Renders the banner that is prepended to each generated file.
     *
     * @return string the rendered banner.
     */
    protected function renderBanner()
    {
        return <<<EOD
/**
 * This file was generated by Caviar.
 * http://github.com/Crisu83/yii-caviar
 */
EOD;
    }
} 