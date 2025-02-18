<?php

namespace App\Http\Controllers\BladeController;

use App\Models\Trip;
use App\Models\Station;
use App\Models\Student;
use App\Models\Transport;
use App\Services\ApiServices\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transports = Transport::all();
            return view('transports.view', compact('transports'));

        } catch (\Exception $e) {
            Log::error('Error fetching transports: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$student_id)
    {
        try {
            $request->validate([
                'trip_id' => 'required|exists:trips,id',
            ]);

            $student = Student::findOrFail($student_id);
            $trip_id = $request->input('trip_id');
            $station_id = $request->input('station_id');
            $trip = Trip::findOrFail($trip_id);

            $user = Auth::user();

            if ($user->role === 'parent' && $trip->status === 1) {
                return redirect()->back()->withErrors(['error' => 'لا يمكنك نقل الطالب إذا كانت الرحلة جارية.']);
            }

            if (count($trip->students)+1 > $trip->bus->number_of_seats) {
                return redirect()->back()->withErrors(['error' => 'لا يوجد مكان فارغ ضمن هذه الرحلة']);
            }

            $transport = new Transport();
            $transport->trip_id = $trip_id;
            $transport->student_id = $student_id;
            $transport->station_id = $station_id;
            $transport->save();

            session()->flash('success', 'تمت عملية نقل الطالب بنجاح');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Error update status student: ' . $e->getMessage());
            return redirect()->back()->withErrors('فشلت عملية النقل: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($transport_id)
    {
        try {
            $transport = Transport::findOrFail($transport_id);
            $student = $transport->student;
            $transport->delete();
            $message = "رفضت عملية نقل الطالب".$student->name;
            $title = "نقل الطالب";
            (new NotificationService())->studentNotification($student,$message,$title);

            session()->flash('success', 'تمت عملية حذف نقل الطالب بنجاح');
            return redirect()->back();

        }catch (\Exception $e) {
            Log::error('Error Deleting Transport: ' . $e->getMessage());
            throw new \Exception('حدث خطأ أثناء محاولة حذف النقل');
        }
    }
}
