<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Personnel;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class Dashboard extends Component
{
    public function render()
    {
        list($sales_labels, $sales_data, $purchases_labels, $purchases_data) = $this->monthlyReport();

        return view('admin.dashboard', [
            'sales_labels' => $sales_labels,
            'sales_data' => $sales_data,
            'purchases_labels' => $purchases_labels,
            'purchases_data' => $purchases_data
        ])->layout(\App\View\Components\AppLayout::class);
    }

    public function getPersonnelNumber()
    {
        return Personnel::count();
    }

    public function getSaleTotal()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        // Sum the 'total' column for sales within the current week
        $totalSalesThisWeek = Sale::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        return $totalSalesThisWeek;
    }

    public function getItemWriteOffNumber()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Count the number of items where the expiration date is in the past
        $expiredItemsCount = Item::where('expiration', '<', $currentDate)->count();

        return $expiredItemsCount;
    }

    public function purchaseDeliveryWeekNumber()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        // $purchaseOrderCount = PurchaseOrder::find(1);

        $purchaseOrderCount = PurchaseOrder::whereHas('purchase_delivery', function ($query) {
                                                        $query->where('purchase_status', '=', 'In Transit');
                                                     })
                                                     ->whereBetween('del_date', [$startDate, $endDate])
                                                     ->count();

        return $purchaseOrderCount;
    }


    public function monthlyReport()
    {
        $sales = Sale::select(DB::raw("SUM(total) as total_sum"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("MONTHNAME(created_at)"))
                    ->orderByRaw("MONTH(created_at)")
                    ->pluck('total_sum', 'month_name');

        $sales_labels = $sales->keys();
        $sales_data = $sales->values();

        $purchases = PurchaseOrder::join('purchase_deliveries', 'purchase_orders.id', '=', 'purchase_deliveries.purchase_order_id')
        ->select(DB::raw("SUM(purchase_orders.total) as total_sum"), DB::raw("MONTHNAME(purchase_orders.created_at) as month_name"))
        ->whereYear('purchase_orders.created_at', date('Y'))
        ->where('purchase_deliveries.purchase_status', 'Delivered')
        ->groupBy(DB::raw("MONTHNAME(purchase_orders.created_at)"))
        ->orderByRaw("MONTH(purchase_orders.created_at)")
        ->pluck('total_sum', 'month_name');

        $purchases_labels = $purchases->keys();
        $purchases_data = $purchases->values();

        return [$sales_labels, $sales_data, $purchases_labels, $purchases_data];
    }
}
