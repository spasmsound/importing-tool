<?php

namespace App\Service\Validator\ContentValidator;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LinkValidator implements ValidatorInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getListPosition(): int
    {
        return 17;
    }

    public function validate(array $data): ?string
    {
        $url = $data[$this->getListPosition()];

        try {
            $response = $this->httpClient->request('GET', $url);

            return 200 === $response->getStatusCode() ? null : $this->getErrorMessage();
        } catch (TransportExceptionInterface $e) {
        }

        return $this->getErrorMessage();
    }

    public function getErrorMessage(): string
    {
        return 'Url is not accessible';
    }
}
