<?php

namespace Swarrot\SwarrotBundle\Broker;

trait UrlParserTrait
{
    /**
     * Parse a RabbitMQ URI into its components.
     *
     * @throws \InvalidArgumentException if the URL can not be parsed.
     */
    private function parseUrl(string $url): array
    {
        $parts = parse_url($url);

        if ($parts === false || !isset($parts['host'])) {
            throw new \InvalidArgumentException(sprintf('Invalid connection URL given: "%s"', $url));
        }

        return [
            'login' => $parts['user'] ?? '',
            'password' => $parts['pass'] ?? '',
            'host' => $parts['host'],
            'port' => (int) ($parts['port'] ?? 5672),
            'vhost' => empty($parts['path']) || $parts['path'] === '/' ? '/' : substr($parts['path'], 1),
        ];
    }
}
