<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\TopUp;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardStatsController extends Controller
{
    /**
     * Menyediakan semua data statistik untuk dashboard.
     */
    public function index()
    {
        // Panggil setiap method private untuk mendapatkan data
        $userGrowth = $this->getUserGrowthData();
        $transactionVolume = $this->getTransactionVolumeData();
        $favoriteBooks = $this->getFavoriteBooksData();
        $categoryDistribution = $this->getCategoryDistributionData();
        $topupStatus = $this->getTopUpStatusData();

        // Gabungkan semua data ke dalam satu response JSON
        return response()->json([
            'userGrowth' => [
                'labels' => array_keys($userGrowth->all()),
                'data' => array_values($userGrowth->all()),
            ],
            'transactionVolume' => [
                'labels' => array_keys($transactionVolume->all()),
                'data' => array_values($transactionVolume->all()),
            ],
            'favoriteBooks' => $favoriteBooks,
            'categoryDistribution' => $categoryDistribution,
            'topupStatus' => $topupStatus,
        ]);
    }

    /**
     * Mengambil data pertumbuhan pengguna selama 30 hari terakhir.
     */
    private function getUserGrowthData()
    {
        $data = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        $dateRange = collect(range(0, 29))->mapWithKeys(function ($i) {
            $date = Carbon::now()->subDays($i);
            $label = $date->locale('id')->isoFormat('D MMM');
            return [$label => 0];
        })->reverse();

        foreach ($data as $date => $count) {
            $label = Carbon::parse($date)->locale('id')->isoFormat('D MMM');
            if ($dateRange->has($label)) {
                $dateRange[$label] = $count;
            }
        }
        
        return $dateRange;
    }

    /**
     * Mengambil data volume transaksi selama 30 hari terakhir.
     */
    private function getTransactionVolumeData()
    {
        $data = Transaction::select(DB::raw('DATE(waktu_transaksi) as date'), DB::raw('count(*) as count'))
            ->where('waktu_transaksi', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        $dateRange = collect(range(0, 29))->mapWithKeys(function ($i) {
            $date = Carbon::now()->subDays($i);
            $label = $date->locale('id')->isoFormat('D MMM');
            return [$label => 0];
        })->reverse();

        foreach ($data as $date => $count) {
            $label = Carbon::parse($date)->locale('id')->isoFormat('D MMM');
            if ($dateRange->has($label)) {
                $dateRange[$label] = $count;
            }
        }
        
        return $dateRange;
    }

    /**
     * Mengambil data 5 buku paling favorit.
     */
    private function getFavoriteBooksData()
    {
        // Relasi `favoritedBy` harus didefinisikan di model Book
        $books = Book::withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'desc')
            ->take(5)
            ->get();
            
        return [
            'labels' => $books->pluck('title'),
            'data' => $books->pluck('favorited_by_count'),
        ];
    }
    
    /**
     * Mengambil data distribusi buku per kategori.
     */
    private function getCategoryDistributionData()
    {
        $categories = Category::withCount('books')->having('books_count', '>', 0)->get();
        return [
            'labels' => $categories->pluck('name'),
            'data' => $categories->pluck('books_count'),
        ];
    }

    /**
     * Mengambil data status permintaan top-up.
     */
    private function getTopUpStatusData()
    {
        $status = TopUp::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        return [
            'labels' => $status->pluck('status'),
            'data' => $status->pluck('total'),
        ];
    }
}
