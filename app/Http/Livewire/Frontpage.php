<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;

    /**
     * The livewire mount function.
     *
     * @param mixed $urlslug
     * @return void
     */
    public function mount($urlslug = null)
    {
        $this->retrieveContent($urlslug);
    }

    /**
     * Retrieve the content of the page.
     *
     * @param mixed $urlslug
     * @return void
     */
    public function retrieveContent($urlslug)
    {
        // Get home page if slug is empty
        if (empty($urlslug))
        {
            $data = Page::where('is_default_home', true)->first();
        } else {
            // Get the page according to the url value
            $data = Page::where('slug', $urlslug)->first();

            // If we can't retrieve anything, let's get the default 404 not found page
            if (!$data) {
                $data = Page::where('is_default_not_found', true)->first();
            }
        }

        $this->title = $data->title;
        $this->content = $data->content;
    }

    /**
     * Get all the sidebar links.
     *
     * @return \Illuminate\Support\Collection
     */
    private function sideBarLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', '=', 'SidebarNav')
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get the top navigation links.
     *
     * @return \Illuminate\Support\Collection
     */
    private function topNavLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', '=', 'TopNav')
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function footerNavLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', '=', 'FooterNav')
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.frontpage', [
            'sidebarLinks' => $this->sideBarLinks(),
            'topNavLinks' => $this->topNavLinks(),
            'footerNavLinks' => $this->footerNavLinks(),
        ])->layout('layouts.frontpage');
    }
}

