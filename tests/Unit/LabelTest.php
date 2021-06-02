<?php declare(strict_types=1);

namespace FromHome\Pdf\Tests\Unit;

use FromHome\Pdf\Label;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class LabelTest extends TestCase
{
	/**
	 * @param string $labelType
	 *
	 * @dataProvider labelTypesProvider
	 */
	public function testNewFromLabelType( string $labelType ) : void
	{
		/** @noinspection UnnecessaryAssertionInspection */
		self::assertInstanceOf( Label::class, Label::newFromLabelType( $labelType ) );
	}

	/**
	 * @return array<array<string, string>>
	 */
	public function labelTypesProvider() : array
	{
		return [
			[
				'labelType' => Label::TYPE_5160,
			],
			[
				'labelType' => Label::TYPE_5161,
			],
			[
				'labelType' => Label::TYPE_5162,
			],
			[
				'labelType' => Label::TYPE_5163,
			],
			[
				'labelType' => Label::TYPE_5164,
			],
			[
				'labelType' => Label::TYPE_8600,
			],
			[
				'labelType' => Label::TYPE_L7161,
			],
			[
				'labelType' => Label::TYPE_L7163,
			],
			[
				'labelType' => Label::TYPE_3422,
			],
			[
				'labelType' => Label::TYPE_NEW_PRINT_4005,
			],
			[
				'labelType' => Label::TYPE_90x54,
			],
			[
				'labelType' => Label::TYPE_138x98,
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
