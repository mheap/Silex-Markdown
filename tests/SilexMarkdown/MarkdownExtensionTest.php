<?php

namespace SilexMarkdown\Tests\Extension;

use PHPUnit\Framework\TestCase;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use SilexMarkdown\MarkdownExtension;
use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;

class MarkdownExtensionTest extends TestCase
{
    public function testRegister()
    {
        $app = new Application();
        $app->register(new MarkdownExtension());
        $this->assertInstanceOf(MarkdownParser::class, $app['markdown']);
    }

    public function testDefaultFeaturesRender()
    {
        $app = new Application();
        $app->register(new MarkdownExtension());
        $text = <<<EOT
My Headline
=====
EOT;

        $this->assertContains('<h1>My Headline</h1>', $app['markdown']->transform($text));
    }

    public function testFeatures()
    {
        $app = new Application();
        $app->register(new MarkdownExtension(), array(
            'markdown.features'   => array(
                'header' => false,
            )
        ));

        $text = <<<EOT
My Headline
=====
EOT;

        $this->assertContains('=====', $app['markdown']->transform($text));
    }

    public function testTwigExtension()
    {
        $app = new Application();
        $app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/views',
        ));
        $app->register(new MarkdownExtension());
        $text = <<<EOT
My Headline
=====
EOT;

        $this->assertContains('<h1>My Headline</h1>', $app['twig']->render('markdown_test.twig', array(
            'input' => $text
        )));
    }
}
