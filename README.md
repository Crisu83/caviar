yii-caviar
==========

Next generation code generation for Yii.

Motivation
----------

You might be wondering why you should use Caviar instead of Gii, so let us take a look at how they differ from each other.

The main disadvantage with Gii is that it is troublesome to write templates for it.
Have you ever looked at one of its templates? If you have you know that they are quite hard to read.
Compare the following [template in Gii](https://github.com/yiisoft/yii/blob/master/framework/gii/generators/model/templates/default/model.php) to the corresponding [template in Caviar](https://github.com/Crisu83/yii-caviar/blob/master/templates/default/model/model.txt).

Caviar uses plain text (.txt files) templates, which are compiled into php files to apply separation of concerns.
This means that all logic must be contained in the generator and that only strings can be passed to the template.
Instead of doing logical operations within the template we do them in the generator when we create the data for the template.
You can take a look at the model generator for an [example](https://github.com/Crisu83/yii-caviar/blob/master/generators/ModelGenerator.php) on this.

Convinced? Follow the instructions below to install Caviar.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist crisu83/yii-caviar "*"
```

or add

```
"crisu83/yii-caviar": "*"
```

to the require section of your `composer.json` file.

Usage
-----

```
yiic generate {generator} {app}:{name} [--key=value] ...
```

Generators
----------

The following generators will be included in the first release:

- component
- config
- controller
- layout
- model
- view
- webapp
