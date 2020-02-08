<?php

namespace Osds\Auth\Infrastructure\UI;

use Osds\DDDCommon\Infrastructure\Persistence\SessionRepository;
use Osds\Auth\Infrastructure\Coder\CoderInterface;

use Osds\Auth\Application\Auth\DeleteServiceTokenApplication;
use Osds\Auth\Application\Auth\StoreServiceTokenApplication;
use Osds\Auth\Application\Auth\CheckIfServiceIsAuthenticatedApplication;
use Osds\Auth\Application\Auth\AuthenticateServiceApplication;

use Osds\Auth\Infrastructure\Coder\JWTCoder;
use Osds\DDDCommon\Domain\Auth\ValueObject\ServiceToken;

use Firebase\JWT\ExpiredException;
use Osds\Auth\Domain\Exception\InvalidTokenException;


class ServiceAuth
{
    public function __construct(
        $session,
        $serviceAuthEndpoint,
        $serviceAuthUser,
        $serviceAuthPassword,
        $coder
    )
    {
        $this->session = $session;
        $this->serviceAuthEndpoint = $serviceAuthEndpoint;
        $this->serviceAuthUser = $serviceAuthUser;
        $this->serviceAuthPassword = $serviceAuthPassword;
        $this->coder = $coder;
    }
    
    #Used by Services. Request a Service Token
    public function getServiceAuthToken($service, $originSite)
	{
        $checkApp = new CheckIfServiceIsAuthenticatedApplication($this->session);
        $serviceToken = $checkApp->execute($service);
        if($serviceToken->get() != null) {
            return $serviceToken->get();
        }

        #service not authenticated yet. make request to get token
	    $authApp = new AuthenticateServiceApplication();
	    $serviceAuth = $authApp->execute(
            $this->serviceAuthEndpoint,
            $this->serviceAuthUser,
            $this->serviceAuthPassword,
            $originSite
        );

	    if($serviceAuth != null && isset($serviceAuth['authToken'])) {

	        $this->storeServiceAuthToken($service, $serviceAuth['authToken']);
	        return $serviceAuth['authToken'];
        }

	    #TODO: die gracely
	    die('no service auth found');

	}

	#Used by API. Encode a Service Token
	public function encodeServiceToken($value)
    {
        return $this->coder->encode($value);
    }

    public static function checkServiceToken($token)
    {
        try {
            if ($token == null) {
                throw new InvalidTokenException;
            }
            $coder = self::getCoder();
            $token = str_replace('Bearer ', '', $token);
            $tokenData = $coder->decode($token);
            return true;
        } catch(ExpiredException $e) {
            #issue a new one
            $tokenData = (array) $coder->decode($token, true);
            $newToken = $coder->encode($tokenData);
            return $newToken;

        } catch(\Exception $e) {
            throw new InvalidTokenException;
        }

        throw new InvalidTokenException;
    }

    public function storeServiceAuthToken($service, $token)
    {
        $serviceApp = new StoreServiceTokenApplication($this->session);
        $serviceApp->execute($service, $token);

        return new ServiceToken($token);
    }


    public function removeServiceAuthToken($service)
    {
        $serviceApp = new DeleteServiceTokenApplication($this->session);
        $serviceApp->execute($service);
    }

    public static function getCoder()
    {
        return new JWTCoder();
    }

	public function setOriginSite($originSite)
    {
        $this->originSite = $originSite;
    }

}
