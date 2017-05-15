<?php

declare(strict_types = 1);

namespace Consistence\ClassFinder\RobotLoader;

use Nette\Loaders\RobotLoader;

class LazyRobotLoaderClassFinderTest extends \PHPUnit\Framework\TestCase
{

	public function testRebuildRobotLoaderOnlyOnFirstRun()
	{
		$robotLoader = $this
			->getMockBuilder(RobotLoader::class)
			->setMethods(['rebuild'])
			->getMock();
		$robotLoader
			->expects($this->once())
			->method('rebuild');

		$lazyClassFinder = new LazyRobotLoaderClassFinder($robotLoader);

		$lazyClassFinder->findByInterface(ExtendingClass::class);
		$lazyClassFinder->findByInterface(ExtendingClass::class);
	}

}
