<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSystemsPrivacyCookieBundle\PrivacyCookieBanner;

interface BannerFactory
{
    /**
     * Builds the privacy cookie banner object, using any kind of data source
     * @return \EzSystems\EzSystemsPrivacyCookieBundle\Banner
     */
    public function build();
}
