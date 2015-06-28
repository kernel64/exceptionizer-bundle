# exceptionizer-bundle     [![SensioLabsInsight](https://insight.sensiolabs.com/projects/2e3ac29c-b1b7-49c0-86af-6349b58d4b88/big.png)](https://insight.sensiolabs.com/projects/2e3ac29c-b1b7-49c0-86af-6349b58d4b88)

[![Build Status](https://scrutinizer-ci.com/g/kernel64/exceptionizer-bundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kernel64/exceptionizer-bundle/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kernel64/exceptionizer-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kernel64/exceptionizer-bundle/?branch=master)

Play with Exceptions :D
This bundle help to get a low coupling between exception class object in your code

## Installation

Exceptionizer uses Composer, please checkout the [composer website](http://getcomposer.org) for more information.

The simple following command will install `exceptionizer-bundle` into your project. It also add a new
entry in your `composer.json` and update the `composer.lock` as well.

```bash
$ composer require 'mabs/exceptionizer-bundle'
```

Then, you can enable it in your kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        ...
        new Mabs\ExceptionizerBundle\MabsExceptionizerBundle(),
        ...
```

## Usage

Now you can use Exceptionizer service to throw Exceptions:

```php
$this->container->get('exceptionizer')
->throwException('\\Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException', array('Your message'));
```

OR define your Exception in your config.yml file like this :

```yml
mabs_exceptionizer:
    exceptions:
        bar_code_exception:
            class: Mabs\BarCodeBundle\Exception\BarCodeException
            arguments:                          # optional
                message: "bar code exception"   # optional
                code:  0                        # optional
```

and pass the config key to the service:

```php
$this->container->get('exceptionizer')->throwException('bar_code_exception');
```

## License

  This bundle is available under the [MIT license](LICENSE).
