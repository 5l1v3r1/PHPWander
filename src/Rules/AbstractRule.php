<?php declare(strict_types=1);

namespace PHPWander\Rules;

use PHPCfg\Op;
use PHPCfg\Operand;
use PHPWander\Analyser\BlockScopeStorage;
use PHPWander\Analyser\FuncCallStorage;
use PHPWander\Analyser\Scope;
use PHPWander\Describer\Describer;
use PHPWander\ScalarTaint;
use PHPWander\Taint;

/**
 * @author Pavel Jurásek
 */
abstract class AbstractRule
{

	/** @var Describer */
	private $describer;

	/** @var BlockScopeStorage */
	private $blockScopeStorage;

	/** @var FuncCallStorage */
	private $funcCallStorage;

	public function __construct(Describer $describer, BlockScopeStorage $blockScopeStorage, FuncCallStorage $funcCallStorage)
	{
		$this->describer = $describer;
		$this->blockScopeStorage = $blockScopeStorage;
		$this->funcCallStorage = $funcCallStorage;
	}

	protected function describeOp(Op $op, Scope $scope): string
	{
		return $this->describer->describe($op, $scope);
	}

	protected function decideOpsTaint(array $ops): Taint
	{
		$taint = new ScalarTaint(Taint::UNKNOWN);
		/** @var Op $op */
		foreach ($ops as $op) {
			$taint = $taint->leastUpperBound($op->getAttribute(Taint::ATTR, new ScalarTaint(Taint::UNKNOWN)));
		}

		return $taint;
	}

	protected function printOp(Op $operand, Scope $scope): string
	{
		return $this->describer->getPrinter()->print($operand, $scope);
	}

	protected function printOperand(Operand $operand, Scope $scope): string
	{
		return $this->describer->getPrinter()->print($operand, $scope);
	}

}
