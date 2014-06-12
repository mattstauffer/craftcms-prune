<?php
namespace Craft;

class PrunePlugin extends BasePlugin
{
    public function getName()
    {
         return Craft::t('Prune');
    }

    public function getVersion()
    {
        return '0.1.0';
    }

    public function getDeveloper()
    {
        return 'ninetwelve (Matt Stauffer)';
    }

    public function getDeveloperUrl()
    {
        return 'http://ninetwelve.co/';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.prune.twigextensions.PruneTwigExtension');

        return new PruneTwigExtension();
    }
}
