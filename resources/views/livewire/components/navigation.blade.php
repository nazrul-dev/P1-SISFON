<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Forms\LogoutForm;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div class="flex flex-col flex-wrap ">
    <div class="flex items-center space-x-2">
        <div class=" h-8 w-8 bg-black rounded-full">

        </div>
        <div class="text-sm">
            <b>{{ auth()->user()->name }}</b>
            <p class="text-xs">{{ auth()->user()->email }}</p>
        </div>
    </div>

</div>
