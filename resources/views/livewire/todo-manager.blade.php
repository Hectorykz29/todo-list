<?php

use Livewire\Volt\Component;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public string $todoName = '';

    public function createTodo()
    {
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        Auth::user()
            ->todos()
            ->create([
                'name' => $this->todoName,
                'completed' => false,
            ]);

        $this->todoName = '';
    }

    public function deleteTodo(int $id)
    {
        $todo = Todo::find($id);
        $this->authorize('delete', $todo);
        $todo->delete();
    }

    public function completeTodo(int $id)
    {
        $todo = Todo::find($id);
        $this->authorize('update', $todo);
        $todo->update(['completed' => true]);

        // Opcionalmente puedes agregar un mensaje o notificación aquí
        $this->dispatchBrowserEvent('todo-completed', ['todoId' => $id]);
    }

    public function with()
    {
        return [
            'todos' => Todo::all(),
        ];
    }
};
?>
<div class="p-6 bg-white">
    <form wire:submit.prevent='createTodo' class="flex items-center space-x-4 mb-8">
        <x-text-input wire:model='todoName' class="flex-1" placeholder="Ingrese una nueva tarea..." />
        <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700">Crear</x-primary-button>
    </form>

    @foreach ($todos as $todo)
        <div wire:transition wire:key='{{ $todo->id }}'
            class="flex items-center justify-between p-4 mb-4 border rounded-lg 
            {{ $todo->completed ? 'bg-red-100 border-red-200' : 'bg-white border-gray-300' }} 
            shadow-md">
            <div class="flex-1 text-sm font-medium {{ $todo->completed ? 'text-gray-400 line-through' : 'text-gray-800' }}">
                {{ $todo->name }}
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-500">
                    {{ $todo->user->name }}
                </span>
                @if (!$todo->completed)
                    <x-primary-button wire:click='completeTodo({{ $todo->id }})'
                        class="bg-red-600 hover:bg-red-700">Completar</x-primary-button>
                @endif
                <x-danger-button wire:click='deleteTodo({{ $todo->id }})'
                    class="bg-red-600 hover:bg-red-700">Borrar</x-danger-button>
            </div>
        </div>
    @endforeach
</div>
