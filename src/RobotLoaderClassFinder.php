<?php

declare(strict_types = 1);

namespace Consistence\ClassFinder\RobotLoader;

use Consistence\Type\ArrayType\ArrayType;
use Nette\Loaders\RobotLoader;

class RobotLoaderClassFinder extends \Consistence\ObjectPrototype implements \Consistence\ClassFinder\ClassFinder
{

	/** @var \Nette\Loaders\RobotLoader */
	private $robotLoader;

	public function __construct(
		RobotLoader $robotLoader
	)
	{
		$this->robotLoader = $robotLoader;
	}

	/**
	 * @param string $interfaceName
	 * @return string[] array of class names
	 */
	public function findByInterface(string $interfaceName)
	{
		return ArrayType::filterValuesByCallback(
			array_keys($this->robotLoader->getIndexedClasses()),
			function ($typeName) use ($interfaceName) {
				return is_a($typeName, $interfaceName, true);
			}
		);
	}

}
