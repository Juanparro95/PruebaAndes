<?php

namespace App\Http\Livewire;

use App\Models\Blog as ModelsBlog;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

	protected $paginationTheme = "bootstrap";

	public $search;
    
    public function render()
    {
        $blogs = ModelsBlog::where('name', 'LIKE', '%' . $this->search . '%')
    				->paginate(8);

        return view('livewire.blog', compact('blogs'));
    }

    public function clear_page(){
    	$this->reset('page');
    }
}
