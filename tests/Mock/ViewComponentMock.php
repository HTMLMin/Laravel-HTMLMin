<?php

namespace HTMLMin\Tests\HTMLMin\Mock;

use Illuminate\View\Component;

class ViewComponentMock extends Component
{
    /**
     * @var string
     */
    private $content;

    /**
     * ViewComponentMock constructor.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    public function render()
    {
        return $this->content;
    }
}
