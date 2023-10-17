<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AuthorProfileHeaders extends Component
{


    public $author;

    protected $listeners = [
        'updateAuthorProfileHeader' => '$refresh'
    ];

    public function mount()
    {
        $this->author = User::find(auth('web')->id());
    }
    public function render()
    {
        return view('livewire.author-profile-headers');
    }
}
