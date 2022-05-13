<?php

declare(strict_types=1);

namespace libs\muqsit\invmenu\session;

use libs\muqsit\invmenu\InvMenu;
use libs\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public InvMenu $menu;
	public InvMenuGraphic $graphic;

	public function __construct(InvMenu $menu, InvMenuGraphic $graphic){
		$this->menu = $menu;
		$this->graphic = $graphic;
	}
}