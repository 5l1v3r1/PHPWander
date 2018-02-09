<?php declare(strict_types = 1);

class A
{

	/** @var array */
	private $source;

	public function __construct(array $source)
	{
		$this->source = $source;
	}

	/**
	 * @return mixed
	 */
	public function getSource(string $index)
	{
		return $this->source[$index];
	}

}

$a = new A($_GET);

// tainted
echo $a->getSource('a');

// ok
echo (int) $a->getSource('a');
