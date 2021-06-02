[![pdf-label](https://github.com/from-home-de/pdf-label/actions/workflows/ci.yml/badge.svg)](https://github.com/from-home-de/pdf-label/actions/workflows/ci.yml)

# PDF label

This is a Label wrapper for TCPDF.

Inspired by: https://github.com/Uskur/PdfLabel

## Usage

This class extends the TCPDF class whose API is [described here](https://tcpdf.org/docs/).

### Via pre-defined label type:

```php
<?php declare(strict_types=1);

use FromHome\Pdf\Label;

$pdf = Label::newFromLabelType(Label::TYPE_L7161);

for($i= 0; $i < $pdf->getLabelsCount(); $i++)
{
    $pdf->addLabel('Label text ' . $i);
}

$pdf->save('/path/to/Labels.pdf');
```

Have a look at the `LABELS` class constant in the [Label class](src/Label.php) for all available, pre-defined formats.

### Via custom format definition:

```php
<?php declare(strict_types=1);

use FromHome\Pdf\Label;

$formatDefinition = [
    'paper-size' => 'A4',
    'unit'       => Label::UNIT_MILLIMETER,
    'marginLeft' => 7,
    'marginTop'  => 10.5,
    'NX'         => 2,
    'NY'         => 2,
    'SpaceX'     => 0,
    'SpaceY'     => 0,
    'width'      => 98,
    'height'     => 138,
    'cutLines'   => true,
];

$pdf = Label::newFromFormatDefinition($formatDefinition);

for($i= 0; $i < $pdf->getLabelsCount(); $i++)
{
    $pdf->addLabel('Label text ' . $i);
}
$pdf->save('/path/to/Labels.pdf');
```

### Save the PDF as a file

```php
$pdf->save('/path/to/Labels.pdf');
```

### Serve the PDF inline in a Browser

```php
$pdf->serveInline('Labels.pdf');
```

### Serve the PDF as a download in a Browser

```php
$pdf->serveAsDownload('Labels.pdf');
```

### Get the content of the PDF as a string

```php
$content = $pdf->getContent();
```

## Customization

You can customize the document setup, header and footer by extending from the Label class as follows:

```php
<?php

use FromHome\Pdf\Label;

final class MyLabel extends Label
{
    public function setUpDocument() : void
    {
        # setup stuff like default font and font-size here         
    }

    public function Header() : void
    {
        # Create a custom header here
        # See: https://tcpdf.org/examples/example_003/
    }
    public function Footer() : void
    {
        # Create a custom footer here
        # See: https://tcpdf.org/examples/example_003/
    }
}
```