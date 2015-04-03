<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSystemsPrivacyCookieBundle\PrivacyCookieBanner\Factory;

use EzSystems\EzSystemsPrivacyCookieBundle\Banner;
use EzSystems\EzSystemsPrivacyCookieBundle\BannerFactory;

class ConfigurationBasedBannerFactory implements BannerFactory
{
    public function __construct( array $configuration = array() )
    {
        $this->configuration = array();
    }

    public function build()
    {
        $banner = new Banner();
        $banner->caption = $this->configuration['caption'];
        // ...
    }
}
