<td
    x-cloak
    x-show="hasHiddenElements"
    class="w-0 {{ data_get($theme, 'tdBodyClass') }}"
    style="{{  data_get($theme, 'tdBodyStyle') }}"
>
    <button
        class="flex items-center"
        x-on:click="toggleExpanded('{{ $rowId }}')"
    >
        <x-livewire-powergrid::icons.arrow
            class="text-pg-primary-600 w-5 h-5 transition-all duration-300"
            x-bind:class="expanded == '{{ $rowId }}' ? 'rotate-90' : '-rotate-0'"
        />
    </button>
</td>
