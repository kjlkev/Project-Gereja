<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $userMonthSelect = $request->input('userMonthSelect');
        $userYearSelect = $request->input('userYearSelect');
        $monthSelect = $request->input('monthSelect');
        $yearSelect = $request->input('yearSelect');
        
        $query = DB::table('users')
            ->leftJoin('ibadah_user', 'users.id', '=', 'ibadah_user.user_id')
            ->select('users.fullname', DB::raw('count(ibadah_user.ibadah_id) as ibadah_count'))
            ->groupBy('users.fullname')
            ->havingRaw('ibadah_count > 0')
            ->orderByDesc('ibadah_count');
        
        $queryMonth = DB::table('users')
            ->leftJoin('ibadah_user', 'users.id', '=', 'ibadah_user.user_id')
            ->leftJoin('ibadahs', 'ibadah_user.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(ibadah_user.ibadah_id) as ibadah_count'))
            ->whereMonth('ibadahs.tanggal', '=', date('m', strtotime($monthSelect)))
            ->whereYear('ibadahs.tanggal', '=', date('Y', strtotime($monthSelect)))
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        
        if (!empty($userMonthSelect)) {
            $queryMonth->where('users.fullname', $userMonthSelect);
        }
        
        $queryYear = DB::table('users')
        ->leftJoin('ibadah_user', 'users.id', '=', 'ibadah_user.user_id')
        ->leftJoin('ibadahs', 'ibadah_user.ibadah_id', '=', 'ibadahs.id')
        ->select('users.fullname', DB::raw('count(ibadah_user.ibadah_id) as ibadah_count'))
        ->whereYear('ibadahs.tanggal', '=', $yearSelect)
        ->groupBy('users.fullname')
        ->orderByDesc('ibadah_count');

        if (!empty($userYearSelect)) {
            $queryYear->where('users.fullname', $userYearSelect);
        }
        //dd($queryYear->get());

        $usersWithIbadahCount = $query->get();
        $month = $queryMonth->get();
        $year = $queryYear->get();
    
        return view('dashboard.jemaat', [
            'title' => 'Dashboard',
            'usersWithIbadahCount' => $usersWithIbadahCount,
            'month' => $month,
            'year' => $year,
            'monthSelect' => $monthSelect,
            'yearSelect' => $yearSelect,
        ]);
    }

    public function usher(Request $request) {
        $usherMonthSelect = $request->input('usherMonthSelect');
        $usherYearSelect = $request->input('usherYearSelect');
        $monthSelect = $request->input('monthSelect');
        $yearSelect = $request->input('yearSelect');

        $query = DB::table('users')
            ->leftJoin('ushers', 'users.id', '=', 'ushers.user_id')
            ->select('users.fullname', DB::raw('count(ushers.ibadah_id) as ibadah_count'))
            ->groupBy('users.fullname')
            ->havingRaw('ibadah_count > 0') // Add this line to filter by ibadah_count > 0
            ->orderByDesc('ibadah_count');

        //dd($query->get());
        $queryMonth = DB::table('users')
            ->leftJoin('ushers', 'users.id', '=', 'ushers.user_id')
            ->leftJoin('ibadahs', 'ushers.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(ushers.ibadah_id) as ibadah_count'))
            ->whereMonth('ibadahs.tanggal', '=', date('m', strtotime($monthSelect)))
            ->whereYear('ibadahs.tanggal', '=', date('Y', strtotime($monthSelect)))
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        // dd($queryMonth->get());
            
        if (!empty($usherMonthSelect)) {
                $queryMonth->where('users.fullname', $usherMonthSelect);
        }
        
        $queryYear = DB::table('users')
            ->leftJoin('ushers', 'users.id', '=', 'ushers.user_id')
            ->leftJoin('ibadahs', 'ushers.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(ushers.ibadah_id) as ibadah_count'))
            ->whereYear('ibadahs.tanggal', '=', $yearSelect)
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');

        // dd($queryYear->get());
        if (!empty($usherYearSelect)) {
            $queryYear->where('users.fullname', $usherYearSelect);
        }
        // dd($queryYear->get());

        $ushersWithIbadahCount = $query->get();
        $month = $queryMonth->get();
        $year = $queryYear->get();
        // dd($year);
        return view('dashboard.usher', [
            'title' => 'Dashboard',
            'ushersWithIbadahCount' => $ushersWithIbadahCount,
            'month' => $month,
            'year' => $year,
            'monthSelect' => $monthSelect,
            'yearSelect' => $yearSelect,
        ]);
    }

    public function avl(Request $request) {
        $avlMonthSelect = $request->input('avlMonthSelect');
        $avlYearSelect = $request->input('avlYearSelect');
        $monthSelect = $request->input('monthSelect');
        $yearSelect = $request->input('yearSelect');

        $query = DB::table('users')
            ->leftJoin('avls', 'users.id', '=', 'avls.user_id')
            ->select('users.fullname', DB::raw('count(avls.ibadah_id) as ibadah_count'))
            ->groupBy('users.fullname')
            ->havingRaw('ibadah_count > 0') // Add this line to filter by ibadah_count > 0
            ->orderByDesc('ibadah_count');

        $queryMonth = DB::table('users')
            ->leftJoin('avls', 'users.id', '=', 'avls.user_id')
            ->leftJoin('ibadahs', 'avls.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(avls.ibadah_id) as ibadah_count'))
            ->whereMonth('ibadahs.tanggal', '=', date('m', strtotime($monthSelect)))
            ->whereYear('ibadahs.tanggal', '=', date('Y', strtotime($monthSelect)))
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        // dd($queryMonth->get());
            
        if (!empty($avlMonthSelect)) {
                $queryMonth->where('users.fullname', $avlMonthSelect);
        }
        
        $queryYear = DB::table('users')
            ->leftJoin('avls', 'users.id', '=', 'avls.user_id')
            ->leftJoin('ibadahs', 'avls.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(avls.ibadah_id) as ibadah_count'))
            ->whereYear('ibadahs.tanggal', '=', $yearSelect)
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        //dd($queryYear->get());

        // dd($queryYear->get());
        if (!empty($avlYearSelect)) {
            $queryYear->where('users.fullname', $avlYearSelect);
        }
        // dd($queryYear->get());

        $avlsWithIbadahCount = $query->get();
        $month = $queryMonth->get();
        $year = $queryYear->get();
        // dd($year);
        return view('dashboard.avl', [
            'title' => 'Dashboard',
            'avlsWithIbadahCount' => $avlsWithIbadahCount,
            'month' => $month,
            'year' => $year,
            'monthSelect' => $monthSelect,
            'yearSelect' => $yearSelect,
        ]);
    }
    
    public function pemusik(Request $request) {
        $pemusikMonthSelect = $request->input('pemusikMonthSelect');
        $pemusikYearSelect = $request->input('pemusikYearSelect');
        $monthSelect = $request->input('monthSelect');
        $yearSelect = $request->input('yearSelect');

        $query = DB::table('users')
            ->leftJoin('pemusiks', 'users.id', '=', 'pemusiks.user_id')
            ->select('users.fullname', DB::raw('count(pemusiks.ibadah_id) as ibadah_count'))
            ->groupBy('users.fullname')
            ->havingRaw('ibadah_count > 0') // Add this line to filter by ibadah_count > 0
            ->orderByDesc('ibadah_count');

        $queryMonth = DB::table('users')
            ->leftJoin('pemusiks', 'users.id', '=', 'pemusiks.user_id')
            ->leftJoin('ibadahs', 'pemusiks.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(pemusiks.ibadah_id) as ibadah_count'))
            ->whereMonth('ibadahs.tanggal', '=', date('m', strtotime($monthSelect)))
            ->whereYear('ibadahs.tanggal', '=', date('Y', strtotime($monthSelect)))
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        // dd($queryMonth->get());
            
        if (!empty($pemusikMonthSelect)) {
                $queryMonth->where('users.fullname', $pemusikMonthSelect);
        }
        
        $queryYear = DB::table('users')
            ->leftJoin('pemusiks', 'users.id', '=', 'pemusiks.user_id')
            ->leftJoin('ibadahs', 'pemusiks.ibadah_id', '=', 'ibadahs.id')
            ->select('users.fullname', DB::raw('count(pemusiks.ibadah_id) as ibadah_count'))
            ->whereYear('ibadahs.tanggal', '=', $yearSelect)
            ->groupBy('users.fullname')
            ->orderByDesc('ibadah_count');
        //dd($queryYear->get());

        // dd($queryYear->get());
        if (!empty($pemusikYearSelect)) {
            $queryYear->where('users.fullname', $pemusikYearSelect);
        }
        // dd($queryYear->get());

        $pemusiksWithIbadahCount = $query->get();
        $month = $queryMonth->get();
        $year = $queryYear->get();
        // dd($year);
        return view('dashboard.pemusik', [
            'title' => 'Dashboard',
            'pemusiksWithIbadahCount' => $pemusiksWithIbadahCount,
            'month' => $month,
            'year' => $year,
            'monthSelect' => $monthSelect,
            'yearSelect' => $yearSelect,
        ]);
    }

    public function usherPdf(Request $request) {
        $yearData = json_decode($request->yearData);
        $yearSelect = json_decode($request->yearSelect);
        
        return view('dashboard.pdf.usher', compact('yearData', 'yearSelect'));
    }

    public function usherYearPdf(Request $request) {
        // dd("test", $request->all());
        //dd($request->all());
        // Retrieve the data needed to generate the PDF
        $yearData = json_decode($request->yearData);
        $yearSelect = json_decode($request->yearSelect);
        // dd($yearData, $yearSelect);

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Set options for the PDF generation (e.g., paper size, orientation)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Specify paper size and orientation
        $options->set('defaultPaperSize', 'A4'); // Adjust the paper size as needed
        $options->set('defaultPaperOrientation', 'landscape'); // 'portrait' or 'landscape'

        $dompdf->setOptions($options);

        // Render the PDF content (You can use a Blade view or HTML for the content)
        $pdfContent = view('dashboard.pdf.usher', compact('yearData', 'yearSelect'))->render();
        //dd($pdfContent);
        // Load the PDF content into Dompdf
        $dompdf->loadHtml($pdfContent);
        // dd($dompdf->loadHtml($pdfContent));
        // dd($pdfContent);

        // Render the PDF (optional: save to a file, stream to a variable, or return it)
        $dompdf->render();

        // Generate a unique file name for the PDF
        $fileName = 'usher_year_report_' . date('Ymd_His') . '.pdf';

        // Stream the PDF to the user's browser as an attachment
        return $dompdf->stream($fileName);
    }
}
