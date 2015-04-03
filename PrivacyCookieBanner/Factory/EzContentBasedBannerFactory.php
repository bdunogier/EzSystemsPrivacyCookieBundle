<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzSystemsPrivacyCookieBundle\PrivacyCookieBanner\Factory;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\URLAliasService;
use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\URLAlias;
use EzSystems\EzSystemsPrivacyCookieBundle\Banner;
use EzSystems\EzSystemsPrivacyCookieBundle\BannerFactory;

/**
 * Builds a Privacy Cookie Banner object based on a configured Content Object.
 *
 * @todo Belongs in DemoBundle, or in EzPlatformPrivacyCookieBundle ;-)
 */
class EzContentBasedBannerFactory implements BannerFactory
{
    /**
     * @var \eZ\Publish\API\Repository\Values\Content\Content
     */
    private $content;
    /**
     * @var \eZ\Publish\API\Repository\LocationService
     */
    private $locationService;
    /**
     * @var \eZ\Publish\API\Repository\URLAliasService
     */
    private $urlAliasService;

    public function __construct( Content $bannerContent, LocationService $locationService, URLAliasService $urlAliasService )
    {
        $this->bannerContent = $bannerContent;
        $this->locationService = $locationService;
        $this->urlAliasService = $urlAliasService;
    }

    public function build()
    {
        $banner = new Banner();
        $banner->caption = $this->content->getFieldValue( 'banner_caption' );
        // ...
        $banner->policyPageUrl = $this->getBannerUrlAlias();
    }

    /**
     * @return \eZ\Publish\API\Repository\Values\Content\URLAlias
     */
    private function getBannerUrlAlias()
    {
        return $this->urlAliasService->reverseLookup(
            $this->locationService->loadLocation(
                $this->bannerContent->contentInfo->mainLocationId
            )
        );
    }
}
