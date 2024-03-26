<?php

namespace App\Livewire\Datatable;

use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Themes\CustomTheme;

final class ItemTable extends PowerGridComponent
{
    use WithExport;

    public function template(): ?string
    {
        return CustomTheme::class;
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->csvSeparator('|')
                ->csvDelimiter("'")
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        config(['livewire-powergrid.filter' => 'outside']);
        return Item::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('barcode_formatted', function ($item) {
                if (isset($item->barcode)) {
                    $barcode = $item->barcode;
                    return '<div class="m-0 p-0">' . DNS1D::getBarcodeHTML("$barcode", 'I25+') . '</div>' . '<div class="tracking-wider" style="margin-left: 40px">' . $barcode . '</div>';
                } else {
                    return 'Barcode not available';
                }
            })
            ->add('barcode')
            ->add('product_name')
            ->add('category', function ($item) {
                switch ($item->category) {
                    case 'beverages':
                        $tag = '<span class="bg-rose-100 rounded-full text-rose-500 px-3 py-1">';
                        break;
                    case 'bread/bakery':
                        $tag = '<span class="bg-teal-100 rounded-full text-teal-500 px-3 py-1">';
                        break;
                    case 'canned/jarred goods':
                        $tag = '<span class="bg-emerald-100 rounded-full text-emerald-500 px-3 py-1">';
                        break;
                    case 'dairy':
                        $tag = '<span class="bg-cyan-100 rounded-full text-cyan-500 px-3 py-1">';
                        break;
                    case 'dry/baking goods':
                        $tag = '<span class="bg-yellow-100 rounded-full text-yellow-700 px-3 py-1">';
                        break;
                    case 'paper goods':
                        $tag = '<span class="bg-fuchsia-100 rounded-full text-fuchsia-500 px-3 py-1">';
                        break;
                    case 'personal care':
                        $tag = '<span class="bg-indigo-100 rounded-full text-indigo-500 px-3 py-1">';
                        break;
                    case 'snacks':
                        $tag = '<span class="bg-amber-100 rounded-full text-amber-500 px-3 py-1">';
                        break;
                    case 'other':
                        $tag = '<span class="bg-stone-200 rounded-full text-stone-500 px-3 py-1">';
                        break;
                }
                return $tag . $item->category . '</span>';
            })
            ->add('expiration_formatted', fn (Item $model) => Carbon::parse($model->expiration)->format('m/d/Y'))
            ->add('qty')
            ->add('selling_unit_price', function ($item) {
                return '₱ ' . $item->selling_unit_price;
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
            ->sortable()
            ->searchable(),

            Column::make('Product name', 'product_name')
                ->sortable()
                ->searchable(),

            Column::make('Barcode', 'barcode_formatted')
                ->sortable()
                ->searchable()
                ->visibleInExport(false),

            Column::make('Barcode', 'barcode')
                ->sortable()
                ->searchable()
                ->hidden()
                ->visibleInExport(true),

            Column::make('Category', 'category')
                ->sortable()
                ->searchable(),

            Column::make('Expiration', 'expiration_formatted', 'expiration')
                ->sortable(),

            Column::make('Qty', 'qty')
                ->sortable()
                ->searchable(),

            Column::make('Price', 'selling_unit_price')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('category')
            ->dataSource(function() {
                $categories = [
                    ['category' => 'Beverages'],
                    ['category' => 'Bread/Bakery'],
                    ['category' => 'Canned/Jarred Goods'],
                    ['category' => 'Dairy'],
                    ['category' => 'Dry/Baking Goods'],
                    ['category' => 'Paper Goods'],
                    ['category' => 'Personal Care'],
                    ['category' => 'Snacks'],
                    ['category' => 'Other']
                ];

                return $categories;
            })
            ->optionLabel('category')
            ->optionValue('category'),

            Filter::boolean('expiration')
                ->label('In-Date', 'Expired')
                ->builder(function (Builder $query, string $value) {
                    if ($value === 'true') {
                        $query->whereDate('expiration', '>=', now());
                    } else {
                        $query->whereDate('expiration', '<', now());
                    }
                }),

            Filter::boolean('qty')
                ->label('In-Stock', 'Out of Stock')
                ->builder(function (Builder $query, string $value) {
                    if ($value === 'true') {
                        $query->where('qty', '>=', 1);
                    } else {
                        $query->where('qty', '<', 1);
                    }
                }),
        ];
    }

    public function actions(\App\Models\Item $row): array
    {
       return [
                Button::add('edit')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
            </svg>')
                ->class('bg-white transform hover:-translate-y-1  border-2 rounded-full duration-500 p-1 text-green-500 border-green-500 hover:bg-green-500 hover:text-white text-2xl')
                ->openModal('modal.item-form', ["id" => $row->id, "action" => 'items.update']),

                Button::add('delete')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>')
                ->class('bg-white transform hover:-translate-y-1  border-2 rounded-full duration-500 p-1 text-red-500 border-red-500 hover:bg-red-500 hover:text-white text-2xl')
                ->openModal('modal.item-form', ["id" => $row->id, "action" => 'items.destroy']),
        ];
    }

    public function header(): array
    {
        $action = URL::route('items.store');
        return [
            Button::add('add')
                ->slot('Add Items')
                ->class('inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150')
                ->openModal('modal.item-form', ["id" => null, "action" => $action]),
        ];
    }
}
