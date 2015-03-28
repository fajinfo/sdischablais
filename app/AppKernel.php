<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Sdis\AccueilBundle\SdisAccueilBundle(),
            new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle(),
            new Sdis\ContactBundle\SdisContactBundle(),
            new Jsp\DynamiqueBundle\JspDynamiqueBundle(),
            new Sdis\DynamiqueBundle\SdisDynamiqueBundle(),
            new Sdis\AdminBundle\SdisAdminBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new FOS\UserBundle\FOSUserBundle(),
            new Jsp\UserBundle\JspUserBundle(),
            new Jsp\AdminBundle\JspAdminBundle(),
            new Sdis\VehiculeBundle\SdisVehiculeBundle(),
	        new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Sdis\AffichageBundle\SdisAffichageBundle(),
            new Sdis\GalerieBundle\SdisGalerieBundle(),
            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
