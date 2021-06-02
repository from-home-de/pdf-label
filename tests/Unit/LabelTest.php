<?php declare(strict_types=1);

namespace FromHome\Pdf\Tests\Unit;

use FromHome\Pdf\Label;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LabelTest extends TestCase
{
	/**
	 * @param string $labelType
	 * @param int    $expectedLabelCount
	 *
	 * @dataProvider labelTypesProvider
	 */
	public function testNewFromLabelType( string $labelType, int $expectedLabelCount ) : void
	{
		self::assertSame( $expectedLabelCount, Label::newFromLabelType( $labelType )->getLabelsCount() );
	}

	/**
	 * @return array<array<string, mixed>>
	 */
	public function labelTypesProvider() : array
	{
		return [
			[
				'labelType'          => Label::TYPE_5160,
				'expectedLabelCount' => 30,
			],
			[
				'labelType'          => Label::TYPE_5161,
				'expectedLabelCount' => 20,
			],
			[
				'labelType'          => Label::TYPE_5162,
				'expectedLabelCount' => 14,
			],
			[
				'labelType'          => Label::TYPE_5163,
				'expectedLabelCount' => 10,
			],
			[
				'labelType'          => Label::TYPE_5164,
				'expectedLabelCount' => 6,
			],
			[
				'labelType'          => Label::TYPE_8600,
				'expectedLabelCount' => 30,
			],
			[
				'labelType'          => Label::TYPE_L7161,
				'expectedLabelCount' => 18,
			],
			[
				'labelType'          => Label::TYPE_L7163,
				'expectedLabelCount' => 14,
			],
			[
				'labelType'          => Label::TYPE_3422,
				'expectedLabelCount' => 24,
			],
			[
				'labelType'          => Label::TYPE_NEW_PRINT_4005,
				'expectedLabelCount' => 8,
			],
			[
				'labelType'          => Label::TYPE_90x54,
				'expectedLabelCount' => 10,
			],
			[
				'labelType'          => Label::TYPE_138x98,
				'expectedLabelCount' => 4,
			],
		];
	}

	public function testNewFromLabelTypeThrowsExceptionForInvalidType() : void
	{
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Unknown label type: invalid' );

		Label::newFromLabelType( 'invalid' );
	}

	public function testNewFromFormatDefinitionThrowsExceptionForInvalidDefinition() : void
	{
		$this->expectException( InvalidArgumentException::class );
		$this->expectExceptionMessage( 'Invalid format definition, missing key: unit' );

		Label::newFromFormatDefinition(
			[
				'paper-size' => 'A4',
				'marginLeft' => 7,
				'marginTop'  => 10.5,
				'NX'         => 2,
				'NY'         => 2,
				'SpaceX'     => 0,
				'SpaceY'     => 0,
				'width'      => 98,
				'height'     => 138,
				'cutLines'   => true,
			]
		);
	}
}
