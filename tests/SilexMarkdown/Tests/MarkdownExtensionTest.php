<?php

namespace SilexMarkdown\Tests\Extension;

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;

use SilexMarkdown\MarkdownExtension;

class MarkdownExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Knp\\Bundle\\MarkdownBundle\\Parser\\MarkdownParser')) {
            $this->markTestSkipped('Knp Markdown Bundle was not installed.');
        }
    }

    public function testRegister()
    {
        $app = new Application();
        $app->register(new MarkdownExtension(), array(

        ));

        $app->get('/', function() use($app) {
            $app['markdown'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $text = <<<EOT
My Headline
=====
EOT;

        $this->assertInstanceOf('\Knp\Bundle\MarkdownBundle\Parser\MarkdownParser', $app['markdown']);
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

        $app->get('/', function() use($app) {
            $app['markdown'];
        });
        $request = Request::create('/');
        $app->handle($request);

        $text = <<<EOT
My Headline
=====
EOT;

        $this->assertNotContains('<h1>My Headline</h1>', $app['markdown']->transform($text));
        $this->assertContains('=====', $app['markdown']->transform($text));
    }

}