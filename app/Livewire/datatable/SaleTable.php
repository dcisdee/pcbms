<?php

namespace App\Livewire\Datatable;

use App\Http\Controllers\LogController;
use App\Models\Sale;
use App\Models\SaleItems;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
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


final class SaleTable extends PowerGridComponent
{
    use WithExport;

    #[On('bulkDelete')]
    public function bulkDelete(): void
    {
        $sale_item_ids = [];
        foreach($this->checkboxValues as $sale_id)
        {
            $sale_items = SaleItems::where('sale_id', $sale_id)->get();

            if ($sale_items) {
                foreach ($sale_items as $sale_item) {
                    $sale_item_ids[] = $sale_item->id;
                    $sale_item->delete();
                }
            }

            Sale::destroy($sale_id);

            $logController = new LogController();
            $logController->store("Sale Transaction Deletion", "success", "deleted", $sale_id);
        }
    }

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
            Header::make()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        config(['livewire-powergrid.filter' => 'outside']);
        return Sale::query()
            ->select([
                'id',
                'transaction_status',
                'total',
                'cash',
                'change',
                'created_at'
            ])
            ->orderBy('created_at', 'ASC');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('transaction_status', function ($sale) {
                switch ($sale->transaction_status) {
                    case 'failed':
                        $tag = '<span class="mx-3 bg-rose-100 rounded-full text-rose-500 px-3 py-1 tracking-widest text-xs">';
                        break;
                    case 'cancelled':
                        $tag = '<span class="mx-3 bg-indigo-100 rounded-full text-indigo-500 px-3 py-1 tracking-widest text-xs">';
                        break;
                    case 'successful':
                        $tag = '<span class="mx-3 bg-emerald-100 rounded-full text-emerald-500 px-3 py-1 tracking-widest text-xs">';
                        break;
                }
                return $tag . strtoupper($sale->transaction_status) . '</span>';
            })
            ->add('cash', function ($sale) {
                return '₱ ' . $sale->cash;
            })
            ->add('total', function ($sale) {
                return '₱ ' . $sale->total;
            })
            ->add('change', function ($sale) {
                return '₱ ' . $sale->change;
            })
            ->add('created_at_formatted', fn (Sale $model) => Carbon::parse($model->created_at)->format('m/d/Y | h:i A'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable()
                ->searchable(),
            Column::make('Transaction Status', 'transaction_status')
                ->sortable(),
            Column::make('Cash', 'cash', 'cash'),
            Column::make('Total', 'total', 'total'),
            Column::make('Change', 'change', 'change'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::action('Action')
        ];
    }

    public function actions(\App\Models\Sale $row): array
    {
       return [
                Button::add('edit')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>')
                ->class('bg-white transform hover:-translate-y-1  border-2 rounded-full duration-500 p-1 text-green-500 border-green-500 hover:bg-green-500 hover:text-white text-2xl')
                ->openModal('modal.sale-form', ["id" => $row->id]),
            ];
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot(__('Bulk delete'))
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete', []),
            ];
    }
}
