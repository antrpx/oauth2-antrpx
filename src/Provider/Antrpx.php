<?php

namespace Antrpx\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Antrpx extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Antrpx resource server URL.
     *
     * @const string
     */
    const BASE_ANTRPX_RESOURCE_SERVER_URL = 'https://api.antrpx.io/v1';

    /**
     * Antrpx authorization server URL.
     *
     * @const string
     */
    const BASE_ANTRPX_AUTH_SERVER_URL = 'https://api.antrpx.io/o';

    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = [
        'accounts:item:read',
        'profiles:list:read',
        'profiles:item:read',
        'metrics:list:read',
        'metrics:item:read'
    ];

    /**
     * @param array $options
     * @param array $collaborators
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        if (empty($options['clientId'])) {
            throw new \InvalidArgumentException('The "clientId" option not set. Please set it.');
        } elseif (empty($options['clientSecret'])) {
            throw new \InvalidArgumentException('The "clientSecret" option not set. Please set it.');
        } elseif (empty($options['redirectUri'])) {
            throw new \InvalidArgumentException('The "redirectUri" option not set. Please set it.');
        }

        parent::__construct($options, $collaborators);
    }

    public function getBaseAuthorizationUrl()
    {
        return static::BASE_ANTRPX_AUTH_SERVER_URL.'/authorize';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return static::BASE_ANTRPX_AUTH_SERVER_URL.'/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return static::BASE_ANTRPX_RESOURCE_SERVER_URL.'/user';
    }

    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    /**
     * Get the string used to separate scopes.
     *
     * @return string
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error']) || $response->getStatusCode() != 200) {
            throw new IdentityProviderException($data['error'], $response->getStatusCode(), $response);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new AntrpxUser($response);
    }
}