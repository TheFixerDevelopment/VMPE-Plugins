<?php

namespace GuiShop\Modals\elements;

use pocketmine\Player;

class Toggle extends UIElement{

	/** @var boolean */
	protected $defaultValue = false;

	/**
	 *
	 * @param string $text
	 * @param bool $value
	 */
	public function __construct(string $text, bool $value = false){
		$this->text = $text;
		$this->defaultValue = $value;
	}

	/**
	 * @param bool $value
	 */
	public function setDefaultValue(bool $value){
		$this->defaultValue = $value;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array{
		return [
			"type" => "toggle",
			"text" => $this->text,
			"default" => $this->defaultValue
		];
	}

	public function handle($value, Player $player){

	}

}
