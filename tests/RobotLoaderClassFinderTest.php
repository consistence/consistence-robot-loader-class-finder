<?php

declare(strict_types = 1);

namespace Consistence\ClassFinder\RobotLoader;

use Generator;
use Nette\Loaders\RobotLoader;
use PHPUnit\Framework\Assert;

class RobotLoaderClassFinderTest extends \PHPUnit\Framework\TestCase
{

	/**
	 * @return mixed[][]|\Generator
	 */
	public function findByInterfaceDataProvider(): Generator
	{
		yield 'class' => [
			'interfaceName' => ExtendingClass::class,
			'expectedClassList' => [
				ExtendingClass::class,
			],
		];
		yield 'class and children' => [
			'interfaceName' => BaseClass::class,
			'expectedClassList' => [
				BaseClass::class,
				ExtendingClass::class,
			],
		];
		yield 'not implemented interface' => [
			'interfaceName' => NotImplementedInterface::class,
			'expectedClassList' => [
				NotImplementedInterface::class,
			],
		];
		yield 'interface and implementations' => [
			'interfaceName' => BaseInterface::class,
			'expectedClassList' => [
				BaseClass::class,
				BaseInterface::class,
				ExtendingClass::class,
				ExtendingInterface::class,
			],
		];
	}

	/**
	 * @dataProvider findByInterfaceDataProvider
	 *
	 * @param string $interfaceName
	 * @param string[] $expectedClassList
	 */
	public function testFindByInterface(
		string $interfaceName,
		array $expectedClassList
	): void
	{
		$classList = array_values($this->getRobotLoaderClassFinder()->findByInterface($interfaceName));

		foreach ($expectedClassList as $expectedClass) {
			Assert::assertContains($expectedClass, $classList);
		}
		Assert::assertCount(count($expectedClassList), $classList);
	}

	private function getRobotLoaderClassFinder(): RobotLoaderClassFinder
	{
		$robotLoader = new RobotLoader();
		$robotLoader->addDirectory(__DIR__ . '/data');
		$robotLoader->rebuild();

		return new RobotLoaderClassFinder($robotLoader);
	}

}
