<?php

declare(strict_types = 1);

namespace Consistence\ClassFinder\RobotLoader;

use Nette\Loaders\RobotLoader;

class LazyRobotLoaderClassFinder extends \Consistence\ClassFinder\RobotLoader\RobotLoaderClassFinder
{

	/** @var \Nette\Loaders\RobotLoader */
	private $robotLoader;

	/** @var bool */
	private $robotLoaderRebuilt;

	public function __construct(
		RobotLoader $robotLoader
	)
	{
		parent::__construct($robotLoader);
		$this->robotLoader = $robotLoader;
		$this->robotLoaderRebuilt = false;
	}

	/**
	 * @param string $interfaceName
	 * @return string[] array of class names
	 */
	public function findByInterface(string $interfaceName)
	{
		if (!$this->robotLoaderRebuilt) {
			$this->robotLoader->rebuild();
			$this->robotLoaderRebuilt = true;
		}

		return parent::findByInterface($interfaceName);
	}

}
