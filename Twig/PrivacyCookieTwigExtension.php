<?php
/**
 * This file is part of the EzSystemsPrivacyCookieBundle package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\PrivacyCookieBundle\Twig;

use \Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;
use \Twig_Function_Method;

/**
 * PrivacyCookie Twig helper which renders necessary snippet code.
 */
class PrivacyCookieTwigExtension extends Twig_Extension
{
    /**
     * we must inject service_container this way
     * @link https://github.com/symfony/symfony/issues/2347
     *
     * @var $container \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * default options
     *
     * @var array
     */
    protected $options = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'ez_privacy_cookie_extension';
    }

    public function getFunctions()
    {
        return [
            'show_privacy_cookie_banner' => new Twig_Function_Method($this, 'showPrivacyCookieBanner', [
                'is_safe' => [ 'html' ]
            ]),
        ];
    }

    /**
     * Set default cookie name.
     *
     * @param $value string
     */
    public function setCookieName($value)
    {
        $this->options[ 'cookieName' ] = $value;
    }

    /**
     * Ses default cookie days validity.
     *
     * @param $value int
     */
    public function setDays($value)
    {
        $this->options[ 'days' ] = $value;
    }

    /**
     * Render cookie privacy banner snippet code
     * - should be included at the end of template before the body ending tag
     *
     * @param string $policyUrl cookie policy page address
     * @param array $options optional parameters:
     *        cookieName - name to be used to store cookie status
     *        days - for how many days this banner should be hidden when user accepts policy?
     *        bannerCaption - replace default banner message caption
     * @return string
     */
    public function showPrivacyCookieBanner($policyUrl, array $options = array())
    {
        return $this->container->get("templating")->render(
            '@EzSystemsPrivacyCookieBundle/Resources/views/privacycookie.html.twig',
            [
                'policyUrl' => $policyUrl,
                'cookieName' => empty($options[ 'cookieName' ]) ? $this->options[ 'cookieName' ] : $options[ 'cookieName' ],
                'days' => empty($options[ 'days' ]) ? $this->options[ 'days' ] : $options[ 'days' ],
                'bannerCaption' => empty($options[ 'bannerCaption' ]) ? null : $options[ 'bannerCaption' ]
            ]
        );
    }
}
