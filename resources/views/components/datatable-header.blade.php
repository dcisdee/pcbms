<div class="inline-flex items-center w-full">
    <span>
        {{ $columnName }}
        {{-- {{ $this->sortColumn !== $columnName  }}- --}}
        {{-- {{ $this->sortDirection === 'ASC'}}- --}}
        {{-- {{ $this->sortColumn == $columnName ? "1" : "0"  }}
        {{ $this->sortColumn . '-' . $columnName . '-' . $this->sortDirection }} --}}

    </span>
    @if ($this->sortColumn !== $columnName)
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-200 ml-1 w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
        </svg>
    @elseif ($this->sortDirection === 'ASC' && $this->sortColumn == $columnName)
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-200 ml-1 w-3 h-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    @elseif ($this->sortDirection === 'DESC' && $this->sortColumn === $columnName)
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-200 ml-1 w-3 h-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    @endif


</div>
