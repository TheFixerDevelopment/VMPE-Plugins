<?php

namespace GuiShop\Modals\elements;

use pocketmine\Player;

class Input extends UIElement{

	/** @var string Text displaying in input without text */
	protected $placeholder = '';
	/** @var string Default text for input */
	protected $defaultText = '';

	/**
	 *
	 * @param string $text
	 * @param string $placeholder
	 * @param string $defaultText
	 */
	public function __construct(string $text, string $placeholder, string $defaultText = ''){
		$this->text = $text;
		$this->placeholder = $placeholder;
		$this->defaultText = $defaultText;
	}

	/**
	 *
	 * @return array
	 */
	final public function jsonSerialize(): array{
		return [
			"type" => "input",
			"text" => $this->text,
			"placeholder" => $this->placeholder,
			"default" => $this->defaultText
		];
	}

	public function handle($value, Player $player){

	}

}
