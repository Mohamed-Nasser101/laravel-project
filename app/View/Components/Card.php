<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $subTitle;
    public $items;
    public $hasLink;
    public $show;
    public function __construct($title,$subTitle,$items,$hasLink,$show)
    {
        $this->items = $items;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->hasLink = $hasLink;
        $this->show = $show;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
