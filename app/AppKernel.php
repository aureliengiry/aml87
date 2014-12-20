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
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        	new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),			
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Aml\Bundle\BlogBundle\AmlBlogBundle(),
            new Aml\Bundle\UsersBundle\AmlUsersBundle(),
            new Aml\Bundle\EvenementsBundle\AmlEvenementsBundle(),
            new Aml\Bundle\MediasBundle\AmlMediasBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Aml\Bundle\AdminBundle\AmlAdminBundle(),
            new Tools\Bundle\MigrationBundle\ToolsMigrationBundle(),
            new Aml\Bundle\ContactUsBundle\AmlContactUsBundle(),
            new Aml\Bundle\DiscographyBundle\AmlDiscographyBundle(),
        );


        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

      //  $bundles[] = new Aml\Bundle\GdataBundle\AmlGdataBundle();
        $bundles[] = new Aml\Bundle\WebBundle\AmlWebBundle();
        
        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
