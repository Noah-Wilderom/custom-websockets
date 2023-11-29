<?php

namespace NoahWilderom\CustomWebsockets;

use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Ratchet\Client\WebSocket;
use React\EventLoop\Factory as LoopFactory;

class CustomBroadcaster extends Broadcaster
{
	protected $loop;

	public function __construct(
		protected array $config
	) {
		$this->loop = LoopFactory::create();
	}

	public function auth($request)
	{
		dd([
			'$request' => $request,
		]);
	}

	public function broadcast(array $channels, $event, array $payload = [])
	{
		dd([
			'$channels' => $channels,
			'$event' => $event,
			'$payload' => $payload,
		]);
	}

	public function validAuthenticationResponse($request, $result)
	{
		dd([
			'$request' => $request,
			'$result' => $result,
		]);
	}

	protected function connectAndSendPayload(array $payload)
	{
		$conn = new \Ratchet\Client\Connector($this->loop);

		$conn(
			url: $this->config['host'],
			headers: [
				//
			]
		)->then(
			onFulfilled: function (WebSocket $conn) use ($payload) {
				$conn->send($payload);
				$conn->close();
			},
			onRejected: function (\Throwable $e) {
				logger()->error(sprintf('Error on Broadcasting: %s', $e->getMessage), $e->getTrace);
			}
		);

		$this->loop->run();
	}
}
