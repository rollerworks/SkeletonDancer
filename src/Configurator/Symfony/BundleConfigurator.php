<?php

/*
 * This file is part of the SkeletonDancer package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Tools\SkeletonDancer\Configurator\Symfony;

use Rollerworks\Tools\SkeletonDancer\Configurator\GeneralConfigurator;
use Rollerworks\Tools\SkeletonDancer\DependentConfigurator;
use Rollerworks\Tools\SkeletonDancer\Question;
use Rollerworks\Tools\SkeletonDancer\QuestionsSet;
use Rollerworks\Tools\SkeletonDancer\StringUtil;

final class BundleConfigurator implements DependentConfigurator
{
    public function interact(QuestionsSet $questions)
    {
        $questions->communicate(
            'sf_bundle_name',
            Question::ask(
                'Bundle name',
                function (array $configuration) {
                    $bundleName = strtr($configuration['namespace'], ['\\Bundle\\' => '', '\\' => '']);
                    $bundleName .= substr($bundleName, -6) === 'Bundle' ? '' : 'Bundle';

                    return $bundleName;
                },
                function ($bundle) {
                    if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $bundle)) {
                        throw new \InvalidArgumentException(
                            sprintf('The bundle name %s contains invalid characters.', $bundle)
                        );
                    }

                    if (!preg_match('/Bundle$/', $bundle)) {
                        throw new \InvalidArgumentException('The bundle name must end with Bundle.');
                    }

                    return $bundle;
                }
            )
        );

        $questions->communicate(
            'sf_extension_name',
            Question::ask(
                'Extension name',
                function (array $configuration) {
                    return substr($configuration['sf_bundle_name'], 0, -6);
                }
            )->markOptional()
        );

        $questions->communicate(
            'sf_extension_alias',
            Question::ask(
                'Extension name',
                function (array $configuration) {
                    return StringUtil::underscore(substr($configuration['sf_bundle_name'], 0, -6));
                }
            )->markOptional()
        );

        $questions->communicate('sf_bundle_config_format', Question::choice('Configuration format', ['yml', 'xml'], 1));

        // XXX Add confirm for: routing (format), Configuration class, service file location (allow null)
        // type of the bundle (http-kernel of framework), full structure (form, controller)
        // separate generator
    }

    public function finalizeConfiguration(array &$configuration)
    {
        $configuration['composer']['type'] = 'symfony-bundle';
    }

    public function getDependencies()
    {
        return [GeneralConfigurator::class];
    }
}