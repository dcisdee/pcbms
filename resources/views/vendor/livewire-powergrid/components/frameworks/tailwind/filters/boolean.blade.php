@props([
    'theme' => '',
    'column' => null,
    'class' => '',
    'inline' => null,
    'filter' => null,
])
@php
    $fieldClassName = data_get($filter, 'className');
    $field = data_get($filter, 'field');
    $title = data_get($column, 'title');

    $trueLabel = data_get($filter, 'trueLabel');
    $falseLabel = data_get($filter, 'falseLabel');

    $defaultAttributes = $fieldClassName::getWireAttributes($field, $title);

    $selectClasses = Arr::toCssClasses([data_get($theme, 'selectClass'), $class, data_get($column, 'headerClass'), 'power_grid']);

    $params = array_merge([...data_get($filter, 'attributes'), ...$defaultAttributes], $filter);
@endphp

@if ($params['component'])
    @unset($params['attributes'])

    <x-dynamic-component
        :component="$params['component']"
        :attributes="new \Illuminate\View\ComponentAttributeBag($params)"
    />
@else
    <div
        class="{{ data_get($theme, 'baseClass') }}"
        style="{{ data_get($theme, 'baseStyle') }}"
    >
        @if (!$inline)
            <label class="block text-sm font-medium text-pg-primary-700">
                {{ $title }}
            </label>
        @endif
        <div class="relative">
            <select
                class="{{ $selectClasses }}"
                style="{{ data_get($column, 'headerStyle') }}"
                {{ $defaultAttributes['selectAttributes'] }}
            >
                <option value="all">{{ trans('livewire-powergrid::datatable.boolean_filter.all') }}</option>
                <option value="true">{{ $trueLabel }}</option>
                <option value="false">{{ $falseLabel }}</option>
            </select>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-pg-primary-700">
                <x-livewire-powergrid::icons.down class="w-4 h-4" />
            </div>
        </div>
    </div>
@endif
