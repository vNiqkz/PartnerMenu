<?php

declare(strict_types=1);

namespace libs\muqsit\invmenu\session\network\handler;

use Closure;
use libs\muqsit\invmenu\session\network\NetworkStackLatencyEntry;

final class ClosurePlayerNetworkHandler implements PlayerNetworkHandler{

	private Closure $creator;

	/**
	 * @param Closure $creator
	 *
	 * @phpstan-param Closure(Closure) : NetworkStackLatencyEntry $creator
	 */
	public function __construct(Closure $creator){
		$this->creator = $creator;
	}

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry{
		return ($this->creator)($then);
	}
}