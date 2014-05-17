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

use crisu83\yii_caviar\components\Config;
use crisu83\yii_caviar\Exception;
use crisu83\yii_caviar\components\File;
use crisu83\yii_caviar\helpers\Line;

abstract class Generator extends \CModel
{
    // constants
    const COMPONENT = 'component';
    const CONFIG = 'config';
    const CONTROLLER = 'controller';
    const CRUD = 'crud';
    const LAYOUT = 'layout';
    const MODEL = 'model';
    const VIEW = 'view';
    const WEBAPP = 'webapp';

    /**
     * @var string name for the item that will be generated.
     */
    public $subject;

    /**
     * @var string name of this generator.
     */
    protected $name = 'base';

    /**
     * @var string short description of what this generator does.
     */
    protected $description = 'Abstract base class for code generation.';

    /**
     * @var string name of the application in which the item will generated.
     */
    protected $context = 'app';

    /**
     * @var Config
     */
    protected static $config;

    /**
     * Generates all necessary files.
     *
     * @return File[] list of files to generate.
     */
    abstract public function generate();

    /**
     * Initializes this generator.
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array(
            array('subject', 'required'),
            array(
                'subject',
                'match',
                'pattern' => '/^[a-zA-Z_]\w*$/',
                'message' => '{attribute} should only contain word characters.'
            ),
        );
    }

    /**
     * Returns short descriptions for the attributes in this generator.
     *
     * @return array attribute descriptions.
     */
    public function attributeHelp()
    {
        return array(
            'subject' => "Name for the item that will be generated.",
        );
    }

    /**
     * @inheritDoc
     */
    public function attributeNames()
    {
        $names = array();

        $class = new \ReflectionClass($this);
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $names[] = $property->name;
        }

        return $names;
    }

    /**
     * Displays the help for this generator.
     */
    public function renderHelp()
    {
        $this->renderHeader();

        echo Line::begin('Usage:', Line::YELLOW)->nl();
        echo Line::begin()
            ->indent(2)
            ->text($this->getUsage())
            ->nl(2);

        // Options
        echo Line::begin('Options:', Line::YELLOW)->nl();
        echo Line::begin()
            ->indent(2)
            ->text('--help', Line::MAGENTA)
            ->to(21)
            ->text('-h', Line::MAGENTA)
            ->text('Display this help message.')
            ->nl(1);

        $attributes = $this->attributeNames();
        $help = $this->attributeHelp();

        sort($attributes);

        foreach ($attributes as $name) {
            echo Line::begin()
                ->indent(2)
                ->text("--$name", Line::MAGENTA)
                ->to(24)
                ->text(isset($help[$name]) ? $help[$name] : '')
                ->nl();
        }

        exit(0);
    }

    /**
     *
     */
    public function renderHeader()
    {
        echo Line::begin(ucfirst($this->name) . ' generator', Line::YELLOW)->nl();
        echo Line::begin()
            ->indent(2)
            ->text($this->description)
            ->nl(2);
    }

    /**
     *
     */
    public function renderErrors()
    {
        echo Line::begin('Errors:', 'red')->nl();

        foreach ($this->getErrors() as $error) {
            echo Line::begin()
                ->indent(2)
                ->text('- ' . $error[0])
                ->nl();
        }

        exit(1);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUsage()
    {
        return "{$this->name} [context:]subject [options]";
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * Creates a new generator.
     *
     * @param string $name name of the generator.
     * @param array $config generator configuration.
     * @return Generator the created generator.
     * @throws Exception if the generator is not found.
     */
    public static function create($name, array $config = array())
    {
        if (!isset(self::$config->generators[$name])) {
            throw new Exception("Unknown generator '$name'.");
        }

        $generator = \Yii::createComponent(\CMap::mergeArray(self::$config->generators[$name], $config));
        $generator->init();

        foreach (self::$config->attributes as $attribute => $value) {
            if (property_exists($generator, $attribute)) {
                $generator->$attribute = $value;
            }
        }

        return $generator;
    }

    /**
     * Creates a generator and renders its help.
     *
     * @param string $name name of the generator.
     */
    public static function help($name)
    {
        self::create($name)->renderHelp();
    }

    /**
     * Creates and runs a specific generator.
     *
     * @param string $name name of the generator.
     * @param array $config generator configuration.
     * @return File[] list of files to generate.
     */
    public static function run($name, array $config = array())
    {
        $generator = self::create($name, $config);

        if (!$generator->validate()) {
            $generator->renderErrors();
        }

        return $generator->generate();
    }

    /**
     * @return Config
     */
    public static function getConfig()
    {
        return self::$config;
    }

    /**
     * @param Config $config
     */
    public static function setConfig(Config $config)
    {
        self::$config = $config;
    }
}