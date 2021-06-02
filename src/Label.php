<?php

namespace FromHome\Pdf;

use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use TCPDF;

class Label extends TCPDF
{
	protected float $marginLeft;

	protected float $marginTop;

	protected float $horizontalLabelSpace;

	protected float $verticalLabelSpace;

	protected int $horizontalLabelCount;

	protected int $verticalLabelCount;

	protected float $labelWidth;

	protected float $labelHeight;

	protected float $labelPadding;

	protected string $sheetUnit;

	protected int $horizontalPosition;

	protected int $verticalPosition;

	protected bool $cutLinesEnabled;

	public const  UNIT_INCH               = 'in';

	public const  UNIT_MILLIMETER         = 'mm';

	private const UNITS                   = [
		self::UNIT_INCH       => 39.37008,
		self::UNIT_MILLIMETER => 1000,
	];

	private const DEFAULT_UNIT            = self::UNIT_MILLIMETER;

	private const CUT_LINE_STYLE          = [
		'width' => 0.3,
		'cap'   => 'butt',
		'join'  => 'miter',
		'dash'  => 1,
		'color' => [200, 200, 200],
	];

	public const  TYPE_5160               = '5160';

	public const  TYPE_5161               = '5161';

	public const  TYPE_5162               = '5162';

	public const  TYPE_5163               = '5163';

	public const  TYPE_5164               = '5164';

	public const  TYPE_8600               = '8600';

	public const  TYPE_L7161              = 'L7161';

	public const  TYPE_L7163              = 'L7163';

	public const  TYPE_3422               = '3422';

	public const  TYPE_NEW_PRINT_4005     = 'NewPrint4005';

	public const  TYPE_90x54              = '90x54';

	public const  TYPE_138x98             = '138x98';

	private const LABELS                  = [
		self::TYPE_5160           => [
			'paper-size' => 'LETTER',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 4.7625,
			'marginTop'  => 12.7,
			'NX'         => 3,
			'NY'         => 10,
			'SpaceX'     => 3.175,
			'SpaceY'     => 0,
			'width'      => 66.675,
			'height'     => 25.4,
			'cutLines'   => false,
		],
		self::TYPE_5161           => [
			'paper-size' => 'LETTER',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 0.967,
			'marginTop'  => 10.7,
			'NX'         => 2,
			'NY'         => 10,
			'SpaceX'     => 3.967,
			'SpaceY'     => 0,
			'width'      => 101.6,
			'height'     => 25.4,
			'cutLines'   => false,
		],
		self::TYPE_5162           => [
			'paper-size' => 'LETTER',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 0.97,
			'marginTop'  => 20.224,
			'NX'         => 2,
			'NY'         => 7,
			'SpaceX'     => 4.762,
			'SpaceY'     => 0,
			'width'      => 100.807,
			'height'     => 35.72,
			'cutLines'   => false,
		],
		self::TYPE_5163           => [
			'paper-size' => 'LETTER',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 1.762,
			'marginTop'  => 10.7,
			'NX'         => 2,
			'NY'         => 5,
			'SpaceX'     => 3.175,
			'SpaceY'     => 0,
			'width'      => 101.6,
			'height'     => 50.8,
			'cutLines'   => false,
		],
		self::TYPE_5164           => [
			'paper-size' => 'LETTER',
			'unit'       => 'in',
			'marginLeft' => 0.148,
			'marginTop'  => 0.5,
			'NX'         => 2,
			'NY'         => 3,
			'SpaceX'     => 0.2031,
			'SpaceY'     => 0,
			'width'      => 4.0,
			'height'     => 3.33,
			'cutLines'   => false,
		],
		self::TYPE_8600           => [
			'paper-size' => 'LETTER',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 7.1,
			'marginTop'  => 19,
			'NX'         => 3,
			'NY'         => 10,
			'SpaceX'     => 9.5,
			'SpaceY'     => 3.1,
			'width'      => 66.6,
			'height'     => 25.4,
			'cutLines'   => false,
		],
		self::TYPE_L7163          => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 5,
			'marginTop'  => 15,
			'NX'         => 2,
			'NY'         => 7,
			'SpaceX'     => 25,
			'SpaceY'     => 0,
			'width'      => 99.1,
			'height'     => 38.1,
			'cutLines'   => false,
		],
		self::TYPE_3422           => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 0,
			'marginTop'  => 8.5,
			'NX'         => 3,
			'NY'         => 8,
			'SpaceX'     => 0,
			'SpaceY'     => 0,
			'width'      => 70,
			'height'     => 35,
			'cutLines'   => false,
		],
		self::TYPE_NEW_PRINT_4005 => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 4,
			'marginTop'  => 15,
			'NX'         => 2,
			'NY'         => 4,
			'SpaceX'     => 3,
			'SpaceY'     => 0,
			'width'      => 99.1,
			'height'     => 67.2,
			'cutLines'   => false,
		],
		self::TYPE_L7161          => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 7.25,
			'marginTop'  => 8.7,
			'NX'         => 3,
			'NY'         => 6,
			'SpaceX'     => 2.5,
			'SpaceY'     => 0,
			'width'      => 63.5,
			'height'     => 46.6,
			'cutLines'   => false,
		],
		self::TYPE_90x54          => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 15,
			'marginTop'  => 13.5,
			'NX'         => 2,
			'NY'         => 5,
			'SpaceX'     => 0,
			'SpaceY'     => 0,
			'width'      => 90,
			'height'     => 55,
			'cutLines'   => true,
		],
		self::TYPE_138x98         => [
			'paper-size' => 'A4',
			'unit'       => self::UNIT_MILLIMETER,
			'marginLeft' => 7,
			'marginTop'  => 10.5,
			'NX'         => 2,
			'NY'         => 2,
			'SpaceX'     => 0,
			'SpaceY'     => 0,
			'width'      => 98,
			'height'     => 138,
			'cutLines'   => true,
		],
	];

	private const FORMAT_DEFINITION_SHAPE = [
		'paper-size' => 'string',
		'unit'       => 'string',
		'marginLeft' => 'float',
		'marginTop'  => 'float',
		'NX'         => 'int',
		'NY'         => 'int',
		'SpaceX'     => 'float',
		'SpaceY'     => 'float',
		'width'      => 'float',
		'height'     => 'float',
		'cutLines'   => 'bool',
	];

	public static function newFromLabelType( string $labelType ) : static
	{
		$formatDefinition = self::LABELS[ $labelType ]
		                    ?? throw new InvalidArgumentException( 'Unknown label type: ' . $labelType );

		return new static( $formatDefinition );
	}

	/**
	 * @param array<string, mixed> $formatDefinition
	 *
	 * @return static
	 */
	public static function newFromFormatDefinition(
		#[ArrayShape(self::FORMAT_DEFINITION_SHAPE)]
		array $formatDefinition
	) : static
	{
		return new static( $formatDefinition );
	}

	/**
	 *
	 * @param array<string, mixed> $formatDefinition
	 *
	 * @throws InvalidArgumentException
	 */
	final private function __construct(
		#[ArrayShape(self::FORMAT_DEFINITION_SHAPE)]
		array $formatDefinition,
	)
	{
		$this->guardFormatDefinitionIsValid( $formatDefinition );

		parent::__construct(
			'P',
			$formatDefinition['unit'],
			$formatDefinition['paper-size'],
			true,
			'UTF-8'
		);

		$this->setViewerPreferences(
			[
				'PrintScaling' => 'None',
			]
		);

		$this->sheetUnit = $formatDefinition['unit'];
		$this->setFormat( $formatDefinition );
		$this->SetMargins( 0, 0 );
		$this->SetAutoPageBreak( false );
		$this->horizontalPosition = -1;
		$this->verticalPosition   = 0;

		$this->setUpDocument();
	}

	/**
	 * @param array<string, mixed> $formatDefinition
	 *
	 * @throws InvalidArgumentException
	 */
	private function guardFormatDefinitionIsValid( array $formatDefinition ) : void
	{
		foreach ( array_keys( self::FORMAT_DEFINITION_SHAPE ) as $key )
		{
			if ( !isset( $formatDefinition[ $key ] ) )
			{
				throw new InvalidArgumentException( 'Invalid format definition, missing key: ' . $key );
			}
		}
	}

	public function setUpDocument() : void { }

	public function Header() : void { }

	public function Footer() : void { }

	/**
	 * @param array<string, mixed> $format
	 */
	protected function setFormat( array $format ) : void
	{
		$this->marginLeft           = $this->convertUnit( $format['marginLeft'], $format['unit'] );
		$this->marginTop            = $this->convertUnit( $format['marginTop'], $format['unit'] );
		$this->horizontalLabelSpace = $this->convertUnit( $format['SpaceX'], $format['unit'] );
		$this->verticalLabelSpace   = $this->convertUnit( $format['SpaceY'], $format['unit'] );
		$this->horizontalLabelCount = $format['NX'];
		$this->verticalLabelCount   = $format['NY'];
		$this->labelWidth           = $this->convertUnit( $format['width'], $format['unit'] );
		$this->labelHeight          = $this->convertUnit( $format['height'], $format['unit'] );
		$this->labelPadding         = $this->convertUnit( $format['padding'] ?? 3, self::DEFAULT_UNIT );
		$this->cutLinesEnabled      = $format['cutLines'] ?? false;
	}

	/**
	 * convert units (in to mm, mm to in)
	 *
	 * @param float  $value
	 * @param string $sourceUnit
	 *
	 * @return float
	 * @throws InvalidArgumentException
	 */
	protected function convertUnit( float $value, string $sourceUnit ) : float
	{
		if ( $sourceUnit !== $this->sheetUnit )
		{
			$srcValue = self::UNITS[ $sourceUnit ]
			            ?? throw new InvalidArgumentException( 'Invalid source unit for conversion: ' . $sourceUnit );

			$dstValue = self::UNITS[ $this->sheetUnit ]
			            ??
			            throw new InvalidArgumentException(
				            'Invalid destination unit for conversion: ' . $this->sheetUnit
			            );

			return $value * $dstValue / $srcValue;
		}

		return $value;
	}

	/** @noinspection UnusedFunctionResultInspection */
	public function addLabel( string $text ) : void
	{
		[$width, $height] = $this->newLabelPosition();

		$this->MultiCell( $width, $height, $text, 0, 'L' );
	}

	/** @noinspection UnusedFunctionResultInspection */
	public function addHtmlLabel( string $html ) : void
	{
		[$width, $height] = $this->newLabelPosition();

		$this->writeHTMLCell( $width, $height, null, null, $html );
	}

	/** @noinspection UnusedFunctionResultInspection */
	public function addHtmlLabelWithBackground( string $html, string $backgroundImageFilePath ) : void
	{
		[$width, $height] = $this->newLabelPosition();
		$this->Image(
			$backgroundImageFilePath,
			$this->GetX() - $this->labelPadding,
			$this->GetY() - $this->labelPadding,
			$this->labelWidth,
			$this->labelHeight
		);
		$this->writeHTMLCell( $width, $height, null, null, $html );
	}

	/**
	 * @return array<float>
	 */
	#[ArrayShape(['float', 'float'])]
	protected function newLabelPosition() : array
	{
		// on a new page if enabled, draw cutlines
		if ( $this->horizontalPosition === 0 && $this->cutLinesEnabled )
		{
			$this->drawCutLines();
		}
		$this->horizontalPosition++;

		if ( $this->horizontalPosition === $this->horizontalLabelCount )
		{
			// Row full, we start a new one
			$this->horizontalPosition = 0;
			$this->verticalPosition++;
			if ( $this->verticalPosition === $this->verticalLabelCount )
			{
				// End of page reached, we start a new one
				$this->verticalPosition = 0;
				$this->AddPage();
			}
		}

		$posX = $this->marginLeft
		        + $this->horizontalPosition * ($this->labelWidth + $this->horizontalLabelSpace)
		        + $this->labelPadding;
		$posY = $this->marginTop
		        + $this->verticalPosition * ($this->labelHeight + $this->verticalLabelSpace)
		        + $this->labelPadding;

		$this->SetXY( $posX, $posY );

		return [
			$this->labelWidth - (2 * $this->labelPadding),
			$this->labelHeight - (2 * $this->labelPadding),
		];
	}

	protected function drawCutLines() : void
	{
		for ( $i = 0; $i < $this->horizontalLabelCount; $i++ )
		{
			$this->drawHorizontalCutLine( $i );
		}

		for ( $i = 0; $i < $this->verticalLabelCount; $i++ )
		{
			$this->drawVerticalCutLine( $i );
		}
	}

	private function drawHorizontalCutLine( int $index ) : void
	{
		$x = $this->marginLeft + ($index * ($this->labelWidth + $this->horizontalLabelSpace));

		if ( $this->cutLinesEnabled )
		{
			$this->Line( $x, 0, $x, $this->marginTop + 1, self::CUT_LINE_STYLE );
			$this->Line(
				$x,
				$this->getPageHeight() - $this->marginTop - 1,
				$x,
				$this->getPageHeight(),
				self::CUT_LINE_STYLE
			);
		}
		else
		{
			$this->Line( $x, 0, $x, $this->getPageHeight(), self::CUT_LINE_STYLE );
		}

		$x = $this->marginLeft
		     + (($index + 1) * ($this->labelWidth + $this->horizontalLabelSpace))
		     - $this->horizontalLabelSpace;

		if ( $this->cutLinesEnabled )
		{
			$this->Line( $x, 0, $x, $this->marginTop + 1, self::CUT_LINE_STYLE );
			$this->Line(
				$x,
				$this->getPageHeight() - $this->marginTop - 1,
				$x,
				$this->getPageHeight(),
				self::CUT_LINE_STYLE
			);
		}
		else
		{
			$this->Line( $x, 0, $x, $this->getPageHeight(), self::CUT_LINE_STYLE );
		}
	}

	private function drawVerticalCutLine( int $index ) : void
	{
		$y = $this->marginTop + ($index * ($this->labelHeight + $this->verticalLabelSpace));

		if ( $this->cutLinesEnabled )
		{
			$this->Line( 0, $y, $this->marginLeft + 1, $y, self::CUT_LINE_STYLE );
			$this->Line(
				$this->getPageWidth() - $this->marginLeft - 1,
				$y,
				$this->getPageWidth(),
				$y,
				self::CUT_LINE_STYLE
			);
		}
		else
		{
			$this->Line( 0, $y, $this->getPageWidth(), $y, self::CUT_LINE_STYLE );
		}

		$y = $this->marginTop
		     + (($index + 1) * ($this->labelHeight + $this->verticalLabelSpace))
		     - $this->verticalLabelSpace;

		if ( $this->cutLinesEnabled )
		{
			$this->Line( 0, $y, $this->marginLeft + 1, $y, self::CUT_LINE_STYLE );
			$this->Line(
				$this->getPageWidth() - $this->marginLeft - 1,
				$y,
				$this->getPageWidth(),
				$y,
				self::CUT_LINE_STYLE
			);
		}
		else
		{
			$this->Line( 0, $y, $this->getPageWidth(), $y, self::CUT_LINE_STYLE );
		}
	}

	public function getLabelsCount() : int
	{
		return $this->horizontalLabelCount * $this->verticalLabelCount;
	}

	public function save( string $filePath ) : void
	{
		/** @noinspection UnusedFunctionResultInspection */
		$this->Output( $filePath, 'F' );
	}

	public function serveInline( string $fileName ) : void
	{
		/** @noinspection UnusedFunctionResultInspection */
		$this->Output( $fileName, 'I' );
	}

	public function serveAsDownload( string $fileName ) : void
	{
		/** @noinspection UnusedFunctionResultInspection */
		$this->Output( $fileName, 'D' );
	}

	public function getContent() : string
	{
		return $this->Output( '', 'S' );
	}
}
