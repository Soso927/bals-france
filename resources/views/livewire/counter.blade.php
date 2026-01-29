<?php

use function Livewire\Volt\{state};

state([
    'count' => 0,
]);

$increment = function () {
    $this->count++;
};

//

?>

<div>
    <h1>Count: {{ $count }}</h1>
    <button wire:click="{{ $increment }}">Increment</button>
</div>
