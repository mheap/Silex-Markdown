<?php


namespace SilexMarkdown;

use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;

class MarkdownTwigExtension extends \Twig_Extension
{
    protected $helper;

    function __construct(MarkdownParser $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return array(
            'markdown' => new \Twig_SimpleFilter('markdown', array($this, 'markdown'), array('is_safe' => array('html'))),
        );
    }

    public function markdown($txt)
    {
        return $this->helper->transform($txt);
    }
}
