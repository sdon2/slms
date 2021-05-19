<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavLink extends Component
{
    public $text;
    public $link;
    public $is_active;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $link = '#', $active = false)
    {
        $this->text = $text;
        $this->link = $link;
        $this->is_active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-link');
    }
}
