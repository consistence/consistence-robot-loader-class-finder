<?php

declare(strict_types = 1);

namespace Consistence\ClassFinder\RobotLoader;

use Nette\Loaders\RobotLoader;

class RobotLoaderClassFinderTest extends \PHPUnit\Framework\TestCase
{

	public function testFindClass(): void
	{
		$classList = array_values($this->getRobotLoaderClassFinder()->findByInterface(ExtendingClass::class));

		$this->assertContains(ExtendingClass::class, $classList);
		$this->assertCount(1, $classList);
	}

	public function testFindClassAndChildren(): void
	{
		$classList = array_values($this->getRobotLoaderClassFinder()->findByInterface(BaseClass::class));
		sort($classList);

		$expected = [
			BaseClass::class,
			ExtendingClass::class,
		];

		$this->assertEquals($expected, $classList);
	}

	public function testFindInterface(): void
	{
		$classList = array_values($this->getRobotLoaderClassFinder()->findByInterface(NotImplementedInterface::class));

		$this->assertContains(NotImplementedInterface::class, $classList);
		$this->assertCount(1, $classList);
	}

	public function testFindInterfaceAndImplementations(): void
	{
		$classList = array_values($this->getRobotLoaderClassFinder()->findByInterface(BaseInterface::class));
		sort($classList);

		$expected = [
			BaseClass::class,
			BaseInterface::class,
			ExtendingClass::class,
			ExtendingInterface::class,
		];

		$this->assertEquals($expected, $classList);
	}

	private function getRobotLoaderClassFinder(): RobotLoaderClassFinder
	{
		$robotLoader = new RobotLoader();
		$robotLoader->addDirectory(__DIR__ . '/data');
		$robotLoader->rebuild();

		return new RobotLoaderClassFinder($robotLoader);
	}

}
