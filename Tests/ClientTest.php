<?php

/**
 * This file is part of the PHPFUI\ConstantContact package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */
class ClientTest extends \PHPUnit\Framework\TestCase
	{
	public function testConnectionFailureWithoutResponse() : void
		{
		$client = $this->getClient(new \GuzzleHttp\Exception\RequestException('connection refused', new \GuzzleHttp\Psr7\Request('GET', '/')));

		$endpoint = new \PHPFUI\ConstantContact\V3\ContactCustomFields($client);

		$this->assertEquals([], $endpoint->get());
		$this->assertEquals(0, $endpoint->getStatusCode());
		$this->assertEquals('connection refused', $endpoint->getLastError());
		}

	public function testErrorResponse() : void
		{
		$client = $this->getClient(new \GuzzleHttp\Psr7\Response(400, [], '{"error":"bad"}'));

		$endpoint = new \PHPFUI\ConstantContact\V3\ContactCustomFields($client);

		$this->assertEquals([], $endpoint->get());
		$this->assertEquals(400, $endpoint->getStatusCode());
		}

	/**
	 * Guzzle 6 MockHandler triggers PHP 8.1 deprecations, so use a plain handler callable that answers with $result.
	 *
	 * @param \Psr\Http\Message\ResponseInterface|\Throwable $result
	 */
	private function getClient($result) : \PHPFUI\ConstantContact\Client
		{
		$client = new \PHPFUI\ConstantContact\Client('key', 'secret', 'https://localhost');
		$handler = static fn () => $result instanceof \Throwable ? \GuzzleHttp\Promise\Create::rejectionFor($result) : \GuzzleHttp\Promise\Create::promiseFor($result);
		$property = new \ReflectionProperty($client, 'guzzleHandler');
		$property->setAccessible(true);
		$property->setValue($client, \GuzzleHttp\HandlerStack::create($handler));

		return $client;
		}
	}
