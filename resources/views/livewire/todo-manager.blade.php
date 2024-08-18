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
    if (!$todo) {
        return response()->json(['error' => 'Tarea no encontrada'], 404);
    }
    if (!$todo->user) {
        return response()->json(['error' => 'La tarea no tiene un usuario asociado'], 403);
    }
    if ($todo->user_id !== Auth::id()) {
        return response()->json(['error' => 'No tienes permiso para completar esta tarea'], 403);
    }
    $todo->update(['completed' => true]);

    return response()->json(['success' => 'Tarea completada exitosamente']);
}

    public function with()
    {
        return [
            'todos' => Todo::all(),
        ];
    }
};
?>
<div class="p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-lg font-bold mb-4">Tareas</h2>
    <form wire:submit.prevent='createTodo' class="flex items-center space-x-4 mb-6">
        <x-text-input wire:model='todoName' class="flex-1" placeholder="Ingrese una nueva tarea..." />
        <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Crear</span>
        </x-primary-button>
    </form>

    @if ($todos->isNotEmpty())
        <div class="space-y-4">
            @foreach ($todos as $todo)
                <div wire:transition wire:key='{{ $todo->id }}'
                    class="flex items-center justify-between p-4 border rounded-lg
                    {{ $todo->completed ? 'bg-red-100 border-red-200' : 'bg-white border-gray-300' }} 
                    shadow-sm transition-all duration-300 ease-in-out">
                    <div class="flex items-center space-x-4 flex-1">
                        <svg class="w-6 h-6 {{ $todo->completed ? 'text-red-500' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            @if ($todo->completed)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v-6m0-4V4m-7 7h14"></path>
                            @endif
                        </svg>
                        <div class="flex-1 text-sm font-medium {{ $todo->completed ? 'text-gray-400 line-through' : 'text-gray-800' }}">
                            {{ $todo->name }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-4 flex-none">
                        <span class="text-sm font-bold text-gray-800">
                            {{ $todo->user->name }}
                        </span>
                        @if (!$todo->completed)
                            <x-primary-button wire:click='completeTodo({{ $todo->id }})'
                                class="bg-red-600 hover:bg-red-700 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Completar</span>
                            </x-primary-button>
                        @endif
                        <x-danger-button wire:click='deleteTodo({{ $todo->id }})'
                            class="bg-red-600 hover:bg-red-700 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Borrar</span>
                        </x-danger-button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-500 py-8">
            No hay tareas asignadas.
        </div>
    @endif
</div>
