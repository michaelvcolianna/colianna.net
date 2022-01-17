<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * The page description.
     *
     * @var string
     */
    public $description;

    /**
     * The page title.
     *
     * @var string
     */
    public $title;

    /**
     * Create a new component instance.
     *
     * @param  string  $title
     * @param  string  $description
     * @return void
     */
    public function __construct($title = 'Home', $description = 'Michael V. Colianna’s author and web developer site.')
    {
        $this->title = $title . ' | Michael V. Colianna';
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layout', [
            'css' => file_get_contents(public_path('css/app.css')),
        ]);
    }
}
