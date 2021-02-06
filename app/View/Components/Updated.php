<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Updated extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $name;
    public $type;
    public $time;
    public $userId;
    public function __construct($type,$name,$time,$userId = null)
    {
        $this->name = $name;
        $this->time = $time;
        $this->type = $type;
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.updated');
    }
}
