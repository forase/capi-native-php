<?php
namespace App\Google;

use Google\AdsApi\AdManager\AdManagerSession;
use Google\AdsApi\AdManager\AdManagerSessionBuilder;
use Google\AdsApi\AdManager\v202111\ApiException;
use Google\AdsApi\AdManager\v202111\ServiceFactory;
use Google\AdsApi\Common\OAuth2TokenBuilder;
/**
 *
 */
class TagManager
{

  function __construct()
  {
    // Generate a refreshable OAuth2 credential for authentication.
    $oAuth2Credential = (new OAuth2TokenBuilder())
        ->fromFile()
        ->build();
    // Construct an API session configured from a properties file and the OAuth2
    // credentials above.
    $session = (new AdManagerSessionBuilder())
        ->fromFile()
        ->withOAuth2Credential($oAuth2Credential)
        ->build();

    // Get a service.
    $serviceFactory = new ServiceFactory();
    $networkService = $serviceFactory->createNetworkService($session);

    // Make a request
    $network = $networkService->getCurrentNetwork();
    printf(
        "Network with code %d and display name '%s' was found.\n",
        $network->getNetworkCode(),
        $network->getDisplayName()
    );
  }
}

?>
