<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\User;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Category;
use App\Models\EarningsNeo;
use App\Models\EarningsUpline;
use App\Models\DepotEncashment;
use Illuminate\Support\Facades\DB;
use App\Models\ProviderDocument;
use App\Models\AppSetting;
use App\Models\Setting;
use App\Models\ProviderPayout;
use App\Models\HandymanPayout;
use App\Models\ServiceFaq;
use App\Models\AppDownload;
use Yajra\DataTables\DataTables;
use App\http\Requests\Auth\LoginRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (request()->ajax()) {
            $start = (!empty($_GET["start"])) ? date('Y-m-d', strtotime($_GET["start"])) : ('');
            $end = (!empty($_GET["end"])) ? date('Y-m-d', strtotime($_GET["end"])) : ('');
            $data =  Booking::myBooking()->where('status', 'pending')->whereDate('date', '>=', $start)->whereDate('date',   '<=', $end)->with('service')->get();
            return response()->json($data);
        }
        $setting_data = Setting::select('value')->where('type', 'dashboard_setting')->where('key', 'dashboard_setting')->first();
        $data['dashboard_setting']  =   !empty($setting_data) ? json_decode($setting_data->value) : [];
        $provider_setting_data = Setting::select('value')->where('type', 'provider_dashboard_setting')->where('key', 'provider_dashboard_setting')->first();
        $data['provider_dashboard_setting']  =  !empty($provider_setting_data) ? json_decode($provider_setting_data->value) : [];
        $handyman_setting_data = Setting::select('value')->where('type', 'handyman_dashboard_setting')->where('key', 'handyman_dashboard_setting')->first();
        $data['handyman_dashboard_setting']  =   !empty($handyman_setting_data) ? json_decode($handyman_setting_data->value) : [];

        $data['dashboard'] = [
            'count_total_booking'               => Booking::myBooking()->count(),
            'count_total_service'               => Service::myService()->count(),
            'count_total_provider'              => User::myUsers('get_provider')->count(),
            'new_customer'                      => User::myUsers('get_customer')->orderBy('id', 'DESC')->take(5)->get(),
            'new_provider'                      => User::myUsers('get_student')->orderBy('id', 'DESC')->take(5)->get(),
            'upcomming_booking'                 => Booking::myBooking()->with('customer')->where('status', 'pending')->orderBy('id', 'DESC')->take(5)->get(),
            'top_services_list'                 => Booking::myBooking()->showServiceCount()->take(5)->get(),
            'count_handyman_pending_booking'    => Booking::myBooking()->where('status', 'pending')->count(),
            'count_handyman_complete_booking'   => Booking::myBooking()->where('status', 'completed')->count(),
            'count_handyman_cancelled_booking'  => Booking::myBooking()->where('status', 'cancelled')->count(),
            'count_total_student'                => User::where('user_type', 'Student')->count(),
            'count_total_BSIT'                => User::where('user_type', 'Student')->where('department', 'BSIT')->count(),
            'count_total_BSENT'                => User::where('user_type', 'Student')->where('department', 'BSENT')->count(),
            'count_total_BTLED'                => User::where('user_type', 'Student')->where('department', 'BTLED')->count()
        ];

        $data['category_chart'] = [
            'chartdata'     => Booking::myBooking()->showServiceCount()->take(4)->get()->pluck('count_pid'),
            'chartlabel'    => Booking::myBooking()->showServiceCount()->take(4)->get()->pluck('service.category.name')
        ];

        $total_revenue  = Payment::where('payment_status', 'paid');
        if (auth()->user()->hasAnyRole(['admin', 'demo_admin'])) {
            $data['revenueData']    =  adminEarning();
        }
        if ($user->hasRole('provider')) {
            $revenuedata = ProviderPayout::selectRaw('sum(amount) as total , DATE_FORMAT(created_at , "%m") as month')
                ->where('provider_id', auth()->user()->id)
                ->whereYear('created_at', date('Y'))
                ->groupBy('month');
            $revenuedata = $revenuedata->get()->toArray();
            $data['revenueData']    =    [];
            $data['revenuelableData']    =    [];
            for ($i = 1; $i <= 12; $i++) {
                $revenueData = 0;
             
                foreach ($revenuedata as $revenue) {
                    if ((int)$revenue['month'] == $i) {
                        $data['revenueData'][] = (int)$revenue['total'];
                        $revenueData++;
                       
                    }
                }
                if ($revenueData == 0) {
                    $data['revenueData'][] = 0;
                }
            }

            $data['currency_data']=currency_data();
        }


        $data['total_revenue']  =    $total_revenue->sum('total_amount');
        if ($user->hasRole('provider')) {
            $total_revenue  = ProviderPayout::where('provider_id', $user->id)->sum('amount') ?? 0;

            $data['total_revenue']=getPriceFormat($total_revenue);
        }
        if ($user->hasRole('handyman')) {
            $data['total_revenue']  = HandymanPayout::where('handyman_id', $user->id)->sum('amount') ?? 0;

          
        }

        if($user->hasRole('Neopreneur')){
            $total_downline = DB::table('users')->where('sp_neo_id', $user->id)->where('user_type', 'provider')
            ->join('bookings', 'users.id', '=', 'bookings.provider_id')
            ->count();

            $total_downline_services = DB::table('users')->where('sp_neo_id', $user->id)->where('user_type', 'provider')
            ->count();

            $total_downline_commission = DB::table('earnings_neo')->where('neo_id', $user->id)->sum('neo_comm');

            $total_sp_rev = DB::table('users')->where('sp_neo_id', $user->id)->where('user_type', 'provider')
            ->join('earnings_service_provider', 'users.id', '=', 'earnings_service_provider.sp_id')
            ->sum('sp_comm');


            $data['neo_total_booking'] = $total_downline;
            $data['neo_total_services'] = $total_downline_services;
            $data['total_downline_commission'] = $total_downline_commission;
            $data['total_sp_rev'] = $total_sp_rev;
            $data['wallet_id'] = $user->id;
        }
        
        if ($user->hasRole('Depot'))
        {
            $data['wallet_id'] = $user->id;
       
            // $total_service_provider = DB::table('users')->where('city_id', $user->city_id )->where('user_type','provider')->count();
            $depotArea = explode(',',$user->area);
            $total_service_provider = 0;
            foreach($depotArea as $area){
                $userCount = DB::table('users')->where('city_id', $area)->where('user_type','provider')->where('status','=','1')->count();
                $total_service_provider += $userCount;
            }
            $area_manager = explode(',',$user->area);
            $depot_total_booking = 0;
            foreach ($area_manager as $area)
            {
                $getspId = DB::table('users')->where('city_id', $area )->where('user_type','provider')->get();
                
                $data['checker'] = $area;
                foreach ($getspId as $sp) 
                {
                    $depot_total_booking = DB::table('bookings')->where('provider_id',$sp->id)->count();
                    
                    $getTotalComs = DB::table('earnings_city_manager')->where('sp_id', $sp->id )->get();
                    if($getTotalComs){
                        $total_commission = 0;
                        foreach($getTotalComs as $getTotalSp)
                        {
                            $total_commission+= (float)$getTotalSp->city_comm;
                        }
                        $data['depot_total_commission']  = $total_commission;
                    }
                    $getTotalSps = DB::table('earnings_service_provider')->where('sp_id', $sp->id )->get();
                    if($getTotalSps){
                        $total_sp_rev = 0;
                        foreach($getTotalSps as $getTotalSp)
                        {
                            $total_sp_rev+= (float)$getTotalSp->sp_comm;
                        }
                        $data['depot_total_sp_rev'] = $total_sp_rev;
                    }
                }
            }
           
            $data['depot_total_booking']     = $depot_total_booking;
            $data['depot_totaL_sp']          = $total_service_provider;
            $data['depot_area']              = $user->area;
            
            
        }

        if (auth()->user()->hasAnyRole(['admin', 'demo_admin'])) {
            return $this->adminDashboard($data);
        } else if (auth()->user()->hasAnyRole('provider')) {
            return $this->providerDashboard($data);
        }
        else if (auth()->user()->hasAnyRole('handyman')) {
            return $this->handymanDashboard($data);
        } else if (auth()->user()->hasAnyRole('Neopreneur')) {
            return $this->neopreneurDashboard($data);
        }
        else if (auth()->user()->hasAnyRole('Depot')){
           return $this->depotDashboard($data);
         }
        else {
            return $this->userDashboard($data);
        }
    }

    /**
     *
     * @param $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     public function booking_view(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = __('messages.list_form_title',['form' => __('messages.booking')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('history.booking-history', compact('pageTitle','auth_user','assets','filter'));
        
    }
     public function booking_view_data(DataTables $datatable,Request $request)
    {
        $query = Booking::query();
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        
        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="booking" onclick="dataTableRowCheck('.$row->id.',this)">';
            })
            ->editColumn('id' , function ($query){
                return "<a class='btn-link btn-link-hover' href=" .route('history.show', $query->id).">#".$query->id ."</a>";
               // return "test";
            })
            // ->editColumn('customer_id' , function ($query){
            //     return ($query->customer_id != null && isset($query->customer)) ? $query->customer->display_name : '';
            // })
            ->editColumn('customer_id' , function ($query){
                return view('booking.customer', compact('query'));
                return "test";
            })
            ->filterColumn('customer_id',function($query,$keyword){
                $query->whereHas('customer',function ($q) use($keyword){
                    $q->where('display_name','like','%'.$keyword.'%');
                });
            })
            ->filterColumn('customer_id',function($query,$keyword){
                $query->whereHas('customer',function ($q) use($keyword){
                    $q->where('email','like','%'.$keyword.'%');
                });
            })
            ->editColumn('service_id' , function ($query){
                $service_name = ($query->service_id != null && isset($query->service)) ? $query->service->name : "";
                return "<a class='btn-link btn-link-hover' href=" .route('history.show', $query->id).">".$service_name ."</a>";
                //return "test";
            })
            ->filterColumn('service_id',function($query,$keyword){
                $query->whereHas('service',function ($q) use($keyword){
                    $q->where('name','like','%'.$keyword.'%');
                });
            })
            ->editColumn('provider_id' , function ($query){
                return ($query->provider_id != null && isset($query->provider)) ? $query->provider->display_name : '';
            })
            ->editColumn('provider_id' , function ($query){
                 return view('booking.provider', compact('query'));
               // return "test";
            })
            ->filterColumn('provider_id',function($query,$keyword){
                $query->whereHas('provider',function ($q) use($keyword){
                    $q->where('display_name','like','%'.$keyword.'%');
                });
            })
            ->filterColumn('provider_id',function($query,$keyword){
                $query->whereHas('provider',function ($q) use($keyword){
                    $q->where('email','like','%'.$keyword.'%');
                });
            })
            ->editColumn('status' , function ($query){
                 return bookingstatus(BookingStatus::bookingStatus($query->status));
               // return "action";
            })
            ->editColumn('payment_id' , function ($query){
                $payment_status = optional($query->payment)->payment_status;
                if($payment_status !== 'paid'){
                    $status = '<span class="badge badge-pay-pending">'.__('messages.pending').'</span>';
                }else{
                    $status = '<span class="badge badge-paid">'.__('messages.paid').'</span>';
                }
                return  $status;
                // return  "ss";
            })
            ->filterColumn('payment_id',function($query,$keyword){
                $query->whereHas('payment',function ($q) use($keyword){
                    $q->where('payment_status','like',$keyword.'%');
                });
            })
            ->editColumn('total_amount' , function ($query){
                return $query->total_amount ? getPriceFormat($query->total_amount) : '-';
            })

            ->addColumn('action', function($booking){
                return view('history.action',compact('booking'))->render();
               // return "test";
            })

            ->editColumn('updated_at', function ($query) {
                $diff = Carbon::now()->diffInHours($query->updated_at);
                if ($diff < 25) {
                    return $query->updated_at->diffForHumans();
                } else {
                    return $query->updated_at->isoFormat('llll');
                }
                //return "sadsd";
            })
            ->addIndexColumn()
            ->rawColumns(['action','status','payment_id','service_id','id','check'])
            ->toJson();
    }
     public function bookingstatus(Request $request, $id)
    {
        $tabpage = $request->tabpage;
        $auth_user = authSession();
        $user_id = $auth_user->id;
        $user_data = User::find($user_id);
        $bookingdata = Booking::with('handymanAdded', 'payment', 'bookingExtraCharge')->myBooking()->find($id);
        switch ($tabpage) {
            case 'info':
                $data  = view('booking.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'bookingdata'))->render();
                break;
            case 'status':
                $data  = view('booking.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'bookingdata'))->render();
                break;
            default:
                $data  = view('booking.' . $tabpage, compact('tabpage', 'auth_user', 'bookingdata'))->render();
                break;
        }
        return response()->json($data); 
    }
    public function history_show($id)
    {
        $auth_user = authSession();

         $user = auth()->user();
         $user->last_notification_seen = now();
         $user->save();

         if(count($user->unreadNotifications) > 0 ) {

          foreach($user->unreadNotifications as $notifications){

              if($notifications['data']['id'] == $id){

                 $notification = $user->unreadNotifications->where('id', $notifications['id'])->first();
                if($notification){
                     $notification->markAsRead();
                      }
                  }
        
             }
                  
        }   

    
        $bookingdata = Booking::with('bookingExtraCharge','payment')->myBooking()->find($id);

       
        $tabpage = 'info';
        if (empty($bookingdata)) {
            $msg = __('messages.not_found_entry', ['name' => __('messages.booking')]);
            return redirect(route('booking_view'))->withError($msg);
        }
        if (count($auth_user->unreadNotifications) > 0) {
            $auth_user->unreadNotifications->where('data.id', $id)->markAsRead();
        }

        $pageTitle = __('messages.view_form_title', ['form' => __('messages.booking')]);
        return view('history.view', compact('pageTitle', 'bookingdata', 'auth_user', 'tabpage'));
    }
    public function historystatus(Request $request, $id)
    {
        $tabpage = $request->tabpage;
        $auth_user = authSession();
        $user_id = $auth_user->id;
        $user_data = User::find($user_id);
        $bookingdata = Booking::with('handymanAdded', 'payment', 'bookingExtraCharge')->myBooking()->find($id);
        switch ($tabpage) {
            case 'info':
                $data  = view('history.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'bookingdata'))->render();
                break;
            case 'status':
                $data  = view('history.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'bookingdata'))->render();
                break;
            default:
                $data  = view('history.' . 'info', compact('tabpage', 'auth_user', 'bookingdata'))->render();
                break;
        }
        return response()->json($data); 
    }
    public function updateStatus(Request $request)
    {
        
        switch ($request->type) {
            case 'payment':
                $data = Payment::where('booking_id',$request->bookingId)->update(['payment_status'=>$request->status]);
                break;
                default:
                
                $data = Booking::find($request->bookingId)->update(['status'=>$request->status]);
                break;
        }
 
        return comman_custom_response(['message'=> 'Status Updated' , 'status' => true]);
    }
    
     public function history_index(DataTables $datatable,Request $request)
     {
        
        $user = auth()->user();
        $query = User::query();
        $booking = Booking::query();
        //   $qw = User::where('id' ,'>' ,0)->get('id')->toarray('id');
     
        //       $q = DB::table('users')->where('user_type','provider')->where('upline', $user->referal_code)->get();
        //   $qwe = DB::table('bookings')->where('provider_id', $qw)->get();
           

 
        // $q = DB::table('users')->where('user_type','provider')->where('upline', $user->referal_code)->get();
     
        // $ass = array();
        // foreach ($q as $tae){
        //     $ass[] = DB::table('bookings')->where('provider_id', $tae->id)->get();
             
        // }
        
       
         
          $query = $query->where('user_type','provider')->where('upline', $user->referal_code)->get();
        
 
          $ass = array();
         
          foreach($query as $tae){
          $ass[] =  $booking->where('provider_id', $tae->id)->get();
          
          }
   
 
    
    
        if (request()->ajax()) {
            $start = (!empty($_GET["start"])) ? date('Y-m-d', strtotime($_GET["start"])) : ('');
            $end = (!empty($_GET["end"])) ? date('Y-m-d', strtotime($_GET["end"])) : ('');
            $data =  Booking::myBooking()->where('status', 'pending')->whereDate('date', '>=', $start)->whereDate('date',   '<=', $end)->with('service')->get();
            return response()->json($data);
        }
        
        $setting_data = Setting::select('value')->where('type', 'dashboard_setting')->where('key', 'dashboard_setting')->first();
        $data['dashboard_setting']  =   !empty($setting_data) ? json_decode($setting_data->value) : [];
     
        
     



    
        

        if (auth()->user()->hasAnyRole(['admin', 'demo_admin'])) {
            return $this->adminDashboard($data);
        } else if (auth()->user()->hasAnyRole('provider')) {
            return $this->providerDashboard($data);
        } else if (auth()->user()->hasAnyRole('handyman')) {
            return $this->handymanDashboard($data);
        } else {
            return $this->historyDashboard($data);
        }
      
     }
     public function transaction_history(DataTables $datatable, Request $request){
        // $user = User::query();
        // $query = Booking::query();
        
        $query = User::query();
        $user = Booking::query();

        $earningNeo = EarningsNeo::get();
        $filter = $request->filter;
        $getUser = auth()->user();
        
        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        if($request->list_status == 'all'){
            $query = $query->whereNotIn('user_type',['admin','demo_admin']);
        }else{
             //$query = $query->where('user_type', 'provider'); 
             $query = $query->where('user_type','provider')->where('upline', $getUser->referal_code)
                 ->rightJoin('bookings', 'users.id', '=', 'bookings.provider_id')
                 ->rightJoin('earnings_neo', 'bookings.id', '=', 'earnings_neo.booking_id')
                 ->select('*', 'bookings.id AS booking_new_id', 'bookings.status AS booking_status');
             
        }   
        return $datatable->eloquent($query)
            ->editColumn('display_name', function($query){
                return '<a class="btn-link btn-link-hover" >'.$query->display_name.'</a>';
            })
            ->filterColumn('display_name',function($query,$keyword){
                $query->where('display_name','like','%'.$keyword.'%');
            })
            // ->editColumn('display_name', function ($query) {
            //     return $query->first_name. " " . $query->last_name;
            // })
            ->editColumn('neo_comm', function($query) {
                return $query->neo_comm;
            })
            ->filterColumn('neo_comm',function($query,$keyword){
                $query->where('neo_comm','like','%'.$keyword.'%');
            })
            ->editColumn('status', function($query) {
                if($query->booking_status != 'completed'){
                    $status = '<span class="badge badge-inactive">'.$query->booking_status.'</span>';
                }else{
                    $status = '<span class="badge badge-active">'.$query->booking_status.'</span>';
                }
                return $status;
            })
            
            ->addColumn('action', function($query){
                return "<a class='btn-link btn-link-hover' href=" .route('booking.show', $query->booking_new_id).">View</a>";
                // return $query->username;
            })
            ->addIndexColumn()
            ->rawColumns(['display_name','action','status'])
            ->toJson();
    }
    public function neo_tag_history(DataTables $datatable, Request $request){
        // $user = User::query();
        // $query = Booking::query();
        
        $query = User::query();
        $user = Booking::query();

        $earningNeo = EarningsNeo::get();
        $filter = $request->filter;
        $getUser = auth()->user();
        
        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        if($request->list_status == 'all'){
            $query = $query->whereNotIn('user_type',['admin','demo_admin']);
        }else{
            $query = $query->where('user_type','provider')->where('sp_neo_id', $getUser->id);
        }   
        return $datatable->eloquent($query)
            ->editColumn('display_name', function($query){
                return '<a class="btn-link btn-link-hover" >'.$query->display_name.'</a>';
            })
            ->filterColumn('display_name',function($query,$keyword){
                $query->where('display_name','like','%'.$keyword.'%');
            })
            ->editColumn('total_booking', function($query) {
                $totalbooking = DB::table('bookings')->where('provider_id', $query->id)->count();
                return $totalbooking;
            })
            ->editColumn('sp_comm', function($query) {
                $totalkomi = DB::table('earnings_service_provider')->where('sp_id', $query->id)->sum('sp_comm');
                return isset($totalkomi) ? $totalkomi : 0;
            })
            ->editColumn('neo_comm', function($query) {
                $neoComms = DB::table('earnings_neo')
                            ->where('neo_id', auth()->user()->id)
                            ->where('sp_id', $query->id)
                            ->sum('neo_comm');
                //$getU = DB::table('users')->where('id', 2597)->join('bookings', 'users.id', '=', 'bookings.provider_id')->join('earnings_neo', 'bookings.id', '=', 'earnings_neo.booking_id')->select('earnings_neo.neo_comm as ye')->sum('ye');
                //->select('*', 'bookings.id AS booking_new_id', 'bookings.status AS booking_status')
                //->join('bookings', 'users.id', '=', 'bookings.provider_id')->join('earnings_neo', 'bookings.id', '=', 'earnings_neo.booking_id')->select('earnings_neo.neo_comm as ye')
                //$getU = DB::table('users')->where('id', '=', $query->id)->join('bookings', 'users.id', '=', 'bookings.provider_id')->join('earnings_neo', 'bookings.id', '=', 'earnings_neo.booking_id')->select('users.first_name as uge')->first();
                // $querye = User::query();
                // $querye = $querye->where('user_type','provider')->where('upline', $getUser->referal_code)->where('id', 2597)
                // ->rightJoin('bookings', 'users.id', '=', 'bookings.provider_id')
                // ->rightJoin('earnings_neo', 'bookings.id', '=', 'earnings_neo.booking_id')
                // ->select('*', 'bookings.id AS booking_new_id', 'bookings.status AS booking_status');
                return $neoComms;
            })
            ->editColumn('comm_persent', function($query) {
                $getCom = DB::table('commission')->first();
                $getComInt = (int)$getCom->neopreneur;
                return $getComInt.'%';
            })
            ->editColumn('total_completed', function($query) {
                $totalCompleted = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'completed')->count();
                return $totalCompleted;
            })
            ->editColumn('total_rejected', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'rejected')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_cancelled', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'cancelled')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_failed', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'failed')->count();
                return isset($total) ? $total : 0;
            })
            // ->filterColumn('sp_comm',function($query,$keyword){
            //     $query->where('sp_comm','like','%'.$keyword.'%');
            // })
            ->addIndexColumn()
            ->rawColumns(['display_name'])
            ->toJson();
    }
    public function depot_encashment(Request $request)
    {
        $amount = $request->amount;
        $type = $request->type;
        $user = auth()->user();
        
        $user_wallet = DB::table('wallets')->where('user_id', $user->id)->first();
        if($amount > $user_wallet->amount || $amount == 0){
            return response()->json(['suc'=> "Wallet must be higher than requested amount"]);
        }
        $encash_pending = DB::table('encashment_history')->where('user_id', $user->id)->where('status', 'Pending')->sum('amount');
        if($encash_pending >= $user_wallet->amount){
            return response()->json(['suc'=> "Still have pending transaction"]);
        }
        $natira = $user_wallet->amount - $encash_pending ;
        if($natira < $amount){
            return response()->json(['suc'=> "Still have pending transaction"]);
        }
        
        $now = Carbon::now();
        $characters = 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $randomString = '';
        $charLength = strlen($characters);
    
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }
        
        $trans_id = $user->id."-".$randomString."-".$now->year.$now->month.$now->dayOfWeek;
        $data = [
            'transaction_id' => $trans_id,
            'user_id'        => $user->id,
            'amount'         => $amount,
            'type'           => $type,
            'status'         => "Pending",
            'created_at'     => $now->toDateTimeString()
            ];
      $insert = DB::table('encashment_history')->insert([
            'transaction_id' => $data['transaction_id'],
            'user_id'        => $data['user_id'],
            'amount'         => $data['amount'],
            'type'           => $data['type'],
            'status'         => $data['status'],
            'created_at'     => $data['created_at']
            ]);
        if($insert){
            return response()->json(['suc'=> "success"]);
        }else{
            return response()->json(['suc'=> "error"]);
        }
        
    }
    public function admin_encashment(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $user_id = $request->userid;
        $now = Carbon::now();
        
        $user_wallet = DB::table('wallets')->where('user_id', $user_id)->first();
        $encashment = DB::table('encashment_history')->where('id', $id)->first();
        if($encashment->status == "Approve"){
            $newWallet = $encashment->amount + $user_wallet->amount;
            DB::table('encashment_history')->where('id', $id)->update(['status' => $status, 'updated_at' => $now->toDateTimeString()]);
            DB::table('wallets')->where('user_id', $user_id)->update(['amount' => $newWallet]);
            return response()->json(['suc'=> "success"]);
        }else{
            if($status == "Approve"){
                $newWallet = $user_wallet->amount - $encashment->amount;
                DB::table('encashment_history')->where('id', $id)->update(['status' => $status, 'updated_at' => $now->toDateTimeString()]);
                DB::table('wallets')->where('user_id', $user_id)->update(['amount' => $newWallet]);
                return response()->json(['suc'=> "success"]);
            }else{
                DB::table('encashment_history')->where('id', $id)->update(['status' => $status, 'updated_at' => $now->toDateTimeString()]);
                return response()->json(['suc'=> "success"]);
            }
           
            
        }
        return response()->json(['suc'=> "error", 'er' => "Error"]); 
        
    }
    public function depot_table(DataTables $datatable, Request $request){
        $query = User::query();
        $user = Booking::query();

        $earningNeo = EarningsNeo::get();
        $filter = $request->filter;
        $getUser = auth()->user();
        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        if($request->list_status == 'all'){
            $query = $query->whereNotIn('user_type',['admin','demo_admin']);
        }else{
          $query = [];
          $allArea = explode(",", auth()->user()->area);
          $text = "";
          foreach($allArea as $newArea){
            $provi = DB::table('users')->where('user_type','provider')->where('city_id', $newArea)->first();
            if($provi){
              array_push($query, [
                    'id' => $provi->id,
                    'display_name' => $provi->display_name
                ]);  
            }
          }
         // $query = DB::table('users')->where('user_type','provider')->where('city_id', 32229)->get();
        }   
       
        
        return Datatables::of($query)
            ->editColumn('display_name', function($query){
                return '<a class="btn-link btn-link-hover" >'.$query['display_name'].'</a>';
            })
            ->editColumn('total_booking', function($query) {
                $totalbooking = DB::table('bookings')->where('provider_id', $query['id'])->count();
                return $totalbooking;
            })
            ->editColumn('sp_comm', function($query) {
                $totalkomi = DB::table('earnings_service_provider')->where('sp_id', $query['id'])->sum('sp_comm');
                return isset($totalkomi) ? $totalkomi : 0;
            })
            ->editColumn('neo_comm', function($query) {
                $neoComms = DB::table('earnings_city_manager')
                            ->where('sp_id', $query['id'])
                            ->sum('city_comm');
                return $neoComms;
            })
            ->editColumn('comm_persent', function($query) {
                $getCom = DB::table('commission')->first();
                $getComInt = (int)$getCom->city_manager;
                return $getComInt.'%';
            })
            ->editColumn('total_completed', function($query) {
                $totalCompleted = DB::table('bookings')->where('provider_id', $query['id'])->where('status', 'completed')->count();
                return $totalCompleted;
            })
            ->editColumn('total_rejected', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query['id'])->where('status', 'rejected')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_cancelled', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query['id'])->where('status', 'cancelled')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_failed', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query['id'])->where('status', 'failed')->count();
                return isset($total) ? $total : 0;
            })
            ->addIndexColumn()
            ->rawColumns(['display_name'])
            ->toJson();
    }
    public function encashment_table(DataTables $datatable, Request $request){
        $query = User::query();
        $user = Booking::query();

        $earningNeo = EarningsNeo::get();
        $filter = $request->filter;
        $getUser = auth()->user();
        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        if($request->list_status == 'all'){
            $query = $query->whereNotIn('user_type',['admin','demo_admin']);
        }else{
        //   $query = [];
          $userInfo = auth()->user();
          if($userInfo->user_type == "admin"){
              
              $query = DB::table('encashment_history')
              ->join('users', 'users.id', '=', 'encashment_history.user_id')
              ->select('encashment_history.*', 'users.display_name', 'users.user_type')
              ->get();
          }else{
              
              $query = DB::table('encashment_history')->where('user_id', $userInfo->id)
              ->join('users', 'users.id', '=', 'encashment_history.user_id')
              ->select('encashment_history.*', 'users.display_name', 'users.user_type')
              ->get();
          }
       
        }   
        return Datatables::of($query)
             ->editColumn('transaction_id', function($query){
                return $query->transaction_id;
            })
            ->editColumn('display_name', function($query){
                return '<a class="btn-link btn-link-hover">'.$query->display_name.'</a>';
            })
            ->editColumn('user_type', function($query){
                return '<a class="btn-link btn-link-hover">'.$query->user_type.'</a>';
            })
            ->editColumn('amount', function($query) {
                return "₱ ". $query->amount.".00";
            })
            ->editColumn('status', function($query) {
                if($query->status == "Pending"){
                    $status = "<span class='text-info'>".$query->status."</span>";
                }elseif($query->status == "Canceled"){
                    $status = "<span class='text-danger'>".$query->status."</span>";
                }elseif($query->status == "Success"){
                    $status = "<span class='text-success'>".$query->status."</span>";
                }
                elseif($query->status == "Approve"){
                    $status = "<span class='text-success'>".$query->status."</span>";
                }
                return $status;
            })
            // ->filterColumn('status',function($query,$keyword){
            //     $query->where('status','like','%'.$keyword.'%');
            // })
            ->editColumn('type', function($query) {
                return $query->type;
            })
            ->editColumn('updated_at', function($query) {
                return $query->updated_at;
            })
            ->editColumn('created_at', function($query) {
                return $query->created_at;
            })
            ->editColumn('action', function($query) {
                $data = $query;
                $stat = $query->status;
                
                return view('encashment.action',compact('data','stat'))->render();
               // return '<button type="button" class="btn btn-danger text-white delbtn" data-data-transid="'.$query['id'].'">'.$query['action'].'</button>';
            })
            ->addIndexColumn()
            ->rawColumns(['display_name','action','status','user_type'])
            ->toJson();
        
        
    }
    public function encashment_delete($id)
    {
        $user = auth()->user();
        if ($user->hasRole('Depot'))
        {
            $data['wallet_id'] = $user->id;
        }
        $wallet = DB::table('wallets')->where('user_id', $data['wallet_id'])->first();
        $encashment = DB::table('encashment_history')->where('id', $id)->first();
        if($encashment){
            DB::table('encashment_history')->where('id', $id)->delete();
            $msg = "success";
        }else{
            $msg = "failed";
        }
        return view('encashment.index', compact('data', 'wallet', 'msg'));
    }
    public function neo_tag_upline_history(DataTables $datatable, Request $request){
        
        $getUser = auth()->user();
        $query = [];
        $getNeo = DB::table('users')->where('user_type', 'Neopreneur')->where('upline', auth()->user()->referal_code)->get();

        foreach($getNeo as $val){
            $getProvider = DB::table('users')->where('user_type', 'provider')->where('upline', $val->referal_code)->get();
            foreach($getProvider as $provVal){
                array_push($query, [
                    'id' => $provVal->id,
                    'display_name' => $provVal->first_name
                ]);
            }
        }
        $query = DB::table('users')->where('user_type', 'provider')->where('sp_upline_id', auth()->user()->id)->get();
        
        return Datatables::of($query)
            ->editColumn('display_name', function($query){
                return '<a class="btn-link btn-link-hover" >'.$query->display_name.'</a>';
            })
            ->editColumn('total_booking', function($query) {
                $totalbooking = DB::table('bookings')->where('provider_id', $query->id)->count();
                return $totalbooking;
            })
            ->editColumn('sp_comm', function($query) {
                $totalkomi = DB::table('earnings_service_provider')->where('sp_id', $query->id)->sum('sp_comm');
                return isset($totalkomi) ? $totalkomi : 0;
            })
            ->editColumn('comm_persent', function($query) {
                $getCom = DB::table('commission')->first();
                $getComInt = (int)$getCom->upline;
                return $getComInt.'%';
            })
            ->editColumn('earnings_upline', function($query) {
                $neoComms = DB::table('earnings_upline')
                            ->where('upline_id', auth()->user()->id)
                            ->where('sp_id', $query->id)
                            ->sum('upline_comm');
                
                return $neoComms;
            })->editColumn('total_completed', function($query) {
                $totalCompleted = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'completed')->count();
                return $totalCompleted;
            })
            ->editColumn('total_rejected', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'rejected')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_cancelled', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'cancelled')->count();
                return isset($total) ? $total : 0;
            })
            ->editColumn('total_failed', function($query) {
                $total = DB::table('bookings')->where('provider_id', $query->id)->where('status', 'failed')->count();
                return isset($total) ? $total : 0;
            })
            ->addIndexColumn()
            ->rawColumns(['display_name'])
            ->toJson();
    }
    public function adminDashboard($data)
    {
        $show = "false";
        $dashboard_setting = Setting::where('type', 'dashboard_setting')->first();

        if ($dashboard_setting == null) {
            $show = "true";
        }
        return view('dashboard.dashboard', compact('data', 'show'));
    }
    public function historyDashboard($data)
    {
        $show = "false";
        $dashboard_setting = Setting::where('type', 'dashboard_setting')->first();

        if ($dashboard_setting == null) {
            $show = "true";
        }
        return view('history.transaction_history', compact('data', 'show'));
    }
    public function neopreneurDashboard($data)
    {
        $show = "false";
        $dashboard_setting = Setting::where('type', 'dashboard_setting')->first();

        if ($dashboard_setting == null) {
            $show = "true";
        }
        $wallet = DB::table('wallets')->where('user_id', $data['wallet_id'])->first();
        return view('dashboard.neo-dashboard-new', compact('data', 'show', 'wallet'));
    }
    public function providerDashboard($data)
    {
        $show = "false";
        $provider_dashboard_setting = Setting::where('type', 'provider_dashboard_setting')->first();

        if ($provider_dashboard_setting == null) {
            $show = "true";
        }
        return view('dashboard.provider-dashboard', compact('data', 'show'));
    }
    public function depotDashboard($data)
    {
        $wallet = DB::table('wallets')->where('user_id', $data['wallet_id'])->first();
       
        return view('dashboard.depot-dashboard', compact('data','wallet'));
    }
    public function handymanDashboard($data)
    {
        $show = "false";
        $handyman_dashboard_setting = Setting::where('type', 'handyman_dashboard_setting')->first();

        if ($handyman_dashboard_setting == null) {
            $show = "true";
        }
        return view('dashboard.handyman-dashboard', compact('data', 'show'));
    }
    public function userDashboard($data)
    {
        return view('dashboard.user-dashboard', compact('data'));
    }
    public function encashment_index(Request $request)
     {
       $user = auth()->user();
       $data['wallet_id'] = $user->id;
       
       return $this->encashment($data);
     }
    public function encashment($data)
    {   
        $wallet = DB::table('wallets')->where('user_id', $data['wallet_id'])->first();
        return view('encashment.index', compact('data','wallet'));
    }
    public function changeStatus(Request $request)
    {
        if (demoUserPermission()) {
            $message = __('messages.demo_permission_denied');
            $response = [
                'status'    => false,
                'message'   => $message
            ];

            return comman_custom_response($response);
        }
        $type = $request->type;
        $message_form = __('messages.item');
        $message = trans('messages.update_form', ['form' => trans('messages.status')]);
        switch ($type) {
            case 'role':
                $role = \App\Models\Role::find($request->id);
                $role->status = $request->status;
                $role->save();
                break;
            case 'category_status':

                $category = \App\Models\Category::find($request->id);
                $category->status = $request->status;
                $category->save();
                break;
            case 'category_featured':
                $message_form = __('messages.category');
                $category = \App\Models\Category::find($request->id);
                $category->is_featured = $request->status;
                $category->save();
                break;
            case 'service_status':
                $service = \App\Models\Service::find($request->id);
                $service->status = $request->status;
                $service->save();
                break;
            case 'coupon_status':
                $coupon = \App\Models\Coupon::find($request->id);
                $coupon->status = $request->status;
                $coupon->save();
                break;
            case 'document_status':
                $document = \App\Models\Documents::find($request->id);
                $document->status = $request->status;
                $document->save();
                break;
            case 'document_required':
                $message_form = __('messages.document');
                $document = \App\Models\Documents::find($request->id);
                $document->is_required = $request->status;
                $document->save();
                break;
            case 'provider_is_verified':
                $message_form = __('messages.providerdocument');
                $document = \App\Models\ProviderDocument::find($request->id);
                $document->is_verified = $request->status;
                $document->save();
                break;
            case 'tax_status':
                $tax = \App\Models\Tax::find($request->id);
                $tax->status = $request->status;
                $tax->save();
                break;
            case 'provideraddress_status':
                $provideraddress = \App\Models\ProviderAddressMapping::find($request->id);
                $provideraddress->status = $request->status;
                $provideraddress->save();
                break;
            case 'slider_status':
                $slider = \App\Models\Slider::find($request->id);
                $slider->status = $request->status;
                $slider->save();
                break;
            case 'servicefaq_status':
                $servicefaq = \App\Models\ServiceFaq::find($request->id);
                $servicefaq->status = $request->status;
                $servicefaq->save();
                break;
            case 'wallet_status':
                $wallet = \App\Models\Wallet::find($request->id);
                $wallet->status = $request->status;
                $wallet->save();
                break;
            case 'subcategory_status':
                $subcategory = \App\Models\SubCategory::find($request->id);
                $subcategory->status = $request->status;
                $subcategory->save();
                break;
            case 'subcategory_featured':
                $message_form = __('messages.subcategory');
                $subcategory = \App\Models\SubCategory::find($request->id);
                $subcategory->is_featured = $request->status;
                $subcategory->save();
                break;
            case 'plan_status':
                $plans = \App\Models\Plans::find($request->id);
                $plans->status = $request->status;
                $plans->save();
                break;
            case 'bank_status':
                $banks = \App\Models\Bank::find($request->id);
                $banks->status = $request->status;
                $banks->save();
                break;
            case 'blog_status':
                $blog = \App\Models\Blog::find($request->id);
                $blog->status = $request->status;
                $blog->save();
                break;
                case 'servicepackage_status':
                    $servicepackage = \App\Models\ServicePackage::find($request->id);
                    $servicepackage->status = $request->status;
                    $servicepackage->save();
                    break;
            default:
                $message = 'error';
                break;
        }
        if ($request->has('is_featured') && $request->is_featured == 'is_featured') {
            $message =  __('messages.added_form', ['form' => $message_form]);
            if ($request->status == 0) {
                $message = __('messages.remove_form', ['form' => $message_form]);
            }
        }
        if ($request->has('is_required') && $request->is_required == 'is_required') {
            $message =  __('messages.added_form', ['form' => $message_form]);
            if ($request->status == 0) {
                $message = __('messages.remove_form', ['form' => $message_form]);
            }
        }
        if ($request->has('provider_is_verified') && $request->provider_is_verified == 'provider_is_verified') {
            $message =  __('messages.added_form', ['form' => $message_form]);
            if ($request->status == 0) {
                $message = __('messages.remove_form', ['form' => $message_form]);
            }
        }
        return comman_custom_response(['message' => $message, 'status' => true]);
    }

    public function getAjaxList(Request $request)
    {
        $items = array();
        $value = $request->q;

        $auth_user = authSession();
        switch ($request->type) {
            case 'permission':
                $items = \App\Models\Permission::select('id', 'name as text')->whereNull('parent_id');
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'category':
                $items = \App\Models\Category::select('id', 'name as text')->where('status', 1);

                if ($value != '') {
                    $items->where('name', 'LIKE', '%' . $value . '%');
                }

                $items = $items->get();
                break;
            case 'subcategory':
                $items = \App\Models\SubCategory::select('id', 'name as text')->where('status', 1);

                if ($value != '') {
                    $items->where('name', 'LIKE', '%' . $value . '%');
                }

                $items = $items->get();
                break;
            case 'provider':
                $items = \App\Models\User::select('id', 'display_name as text')
                    ->where('user_type', 'Student')
                    ->where('status', 1);

                if ($value != '') {
                    $items->where('display_name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;

            case 'user':
                $items = \App\Models\User::select('id', 'display_name as text')
                    ->where('user_type', 'user')
                    ->where('status', 1);

                if ($value != '') {
                    $items->where('display_name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;

                case 'provider-user':
                    $items = \App\Models\User::select('id', 'display_name as text')
                        ->where('user_type', 'provider')
                        ->where('status', 1);
                        // ->where('user_type', 'provider')->orWhere('user_type','user')
                    if ($value != '') {
                        $items->where('display_name', 'LIKE', $value . '%');
                    }
    
                    $items = $items->get();
                    break;

            case 'handyman':
                $items = \App\Models\User::select('id', 'display_name as text')
                    ->where('user_type', 'handyman')
                    ->where('status', 1);

                if (isset($request->provider_id)) {
                    $items->where('provider_id', $request->provider_id);
                }

                if (isset($request->booking_id)) {
                    $booking_data = Booking::find($request->booking_id);

                    $service_address = $booking_data->handymanByAddress;
                    if ($service_address != null) {
                        $items->where('service_address_id', $service_address->id);
                    }
                }

                if ($value != '') {
                    $items->where('display_name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;
            case 'service':
                $items = \App\Models\Service::select('id', 'name as text')->where('status', 1);

                if ($value != '') {
                    $items->where('name', 'LIKE', '%' . $value . '%');
                }
                if (isset($request->provider_id)) {
                    $items->where('provider_id', $request->provider_id);
                }

                $items = $items->get();
                break;
            case 'service-list':
                    $items = \App\Models\Service::select('id', 'name as text')->where('status', 1)->where('service_type','service');
    
                    if ($value != '') {
                        $items->where('name', 'LIKE', '%' . $value . '%');
                    }
                    if (isset($request->provider_id)) {
                        $items->where('provider_id', $request->provider_id);
                    }
    
                    $items = $items->get();
                    break;
            case 'providertype':
                $items = \App\Models\ProviderType::select('id', 'name as text')
                    ->where('status', 1);

                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;
            case 'coupon':
                $items = \App\Models\Coupon::select('id', 'code as text')->where('status', 1);

                if ($value != '') {
                    $items->where('code', 'LIKE', '%' . $value . '%');
                }

                $items = $items->get();
                break;

                case 'bank':
                    $items = \App\Models\Bank::select('id', 'bank_name as text')->where('provider_id',$request->provider_id)->where('status',1);
    
                    if ($value != '') {
                        $items->where('name', 'LIKE', $value . '%');
                    }
                    $items = $items->get();
                    break;

            case 'country':
                $items = \App\Models\Country::select('id', 'name as text');

                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'state':
                $items = \App\Models\State::select('id', 'name as text');
                if (isset($request->country_id)) {
                    $items->where('country_id', $request->country_id);
                }
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'city':
                $items = \App\Models\City::select('id', 'name as text');
                if (isset($request->state_id)) {
                    $items->where('state_id', $request->state_id);
                }
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'booking_status':
                $items = \App\Models\BookingStatus::select('id', 'label as text');

                if ($value != '') {
                    $items->where('label', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'currency':
                $items = \DB::table('countries')->select(\DB::raw('id id,CONCAT(name , " ( " , symbol ," ) ") text'));

                $items->whereNotNull('symbol')->where('symbol', '!=', '');
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%')->orWhere('currency_code', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'country_code':
                $items = \DB::table('countries')->select(\DB::raw('code id,name text'));
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%')->orWhere('code', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;

            case 'time_zone':
                $items = timeZoneList();

                foreach ($items as $k => $v) {

                    if ($value != '') {
                        if (strpos($v, $value) !== false) {
                        } else {
                            unset($items[$k]);
                        }
                    }
                }

                $data = [];
                $i = 0;
                foreach ($items as $key => $row) {
                    $data[$i] = [
                        'id'    => $key,
                        'text'  => $row,
                    ];
                    $i++;
                }
                $items = $data;
                break;
            case 'provider_address':
                $provider_id = !empty($request->provider_id) ? $request->provider_id : $auth_user->id;
                $items = \App\Models\ProviderAddressMapping::select('id', 'address as text', 'latitude', 'longitude', 'status')->where('provider_id', $provider_id)->where('status', 1);
                $items = $items->get();
                break;

            case 'provider_tax':
                $provider_id = !empty($request->provider_id) ? $request->provider_id : $auth_user->id;
                $items = \App\Models\Tax::select('id', 'title as text')->where('status', 1);
                $items = $items->get();
                break;

            case 'documents':
                $items = \App\Models\Documents::select('id', 'name', 'status', 'is_required', \DB::raw('(CASE WHEN is_required = 1 THEN CONCAT(name," * ") ELSE CONCAT(name,"") END) AS text'))->where('status', 1);
                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }
                $items = $items->get();
                break;
            case 'handymantype':
                $items = \App\Models\HandymanType::select('id', 'name as text')
                    ->where('status', 1);

                if ($value != '') {
                    $items->where('name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;
            case 'subcategory_list':
                $category_id = !empty($request->category_id) ? $request->category_id : '';
                $items = \App\Models\SubCategory::select('id', 'name as text')->where('category_id', $category_id)->where('status', 1);
                $items = $items->get();
                break;
            case 'service_package':
                $service_id = !empty($request->service_id) ? $request->service_id : $auth_user->id;
                $items = \App\Models\ServicePackage::select('id', 'description as text', 'status')->where('provider_id', $service_id)->where('status', 1);
                $items = $items->get();
                break;
            case 'all_user':
                $items = \App\Models\User::select('id', 'display_name as text')
                    ->where('status', 1);

                if ($value != '') {
                    $items->where('display_name', 'LIKE', $value . '%');
                }

                $items = $items->get();
                break;
            default:
                break;
        }
        return response()->json(['status' => 'true', 'results' => $items]);
    }

    public function removeFile(Request $request)
    {
        if (demoUserPermission()) {
            $message = __('messages.demo_permission_denied');
            $response = [
                'status'    => false,
                'message'   => $message
            ];

            return comman_custom_response($response);
        }

        $type = $request->type;
        $data = null;
        switch ($type) {
            case 'slider_image':
                $data = Slider::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.slider')]);
                break;
            case 'profile_image':
                $data = User::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.profile_image')]);
                break;
            case 'service_attachment':
                $media = Media::find($request->id);
                $media->delete();
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'category_image':
                $data = Category::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.category')]);
                break;
            case 'provider_document':
                $data = ProviderDocument::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.providerdocument')]);
                break;
            case 'booking_attachment':
                $media = Media::find($request->id);
                $media->delete();
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'bank_attachment':
                $media = Media::find($request->id);
                $media->delete();
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'app_image':
                $data = AppDownload::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'app_image_full':
                $data = AppDownload::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'package_attachment':
                $media = Media::find($request->id);
                $media->delete();
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            case 'blog_attachment':
                $media = Media::find($request->id);
                $media->delete();
                $message = __('messages.msg_removed', ['name' => __('messages.attachments')]);
                break;
            default:
                $data = AppSetting::find($request->id);
                $message = __('messages.msg_removed', ['name' => __('messages.image')]);
                break;
        }

        if ($data != null) {
            $data->clearMediaCollection($type);
        }

        $response = [
            'status'    => true,
            'image'     => getSingleMedia($data, $type),
            'id'        => $request->id,
            'preview'   => $type . "_preview",
            'message'   => $message
        ];

        return comman_custom_response($response);
    }

    public function lang($locale)
    {
        \App::setLocale($locale);
        session()->put('locale', $locale);
        \Artisan::call('cache:clear');
        $dir = 'ltr';
        if (in_array($locale, ['ar', 'dv', 'ff', 'ur', 'he', 'ku', 'fa'])) {
            $dir = 'rtl';
        }

        session()->put('dir',  $dir);
        return redirect()->back();
    }

    function authLogin()
    {
        return view('auth.login');
    }
    function authRegister()
    {
        return view('auth.register');
    }

    function authRecoverPassword()
    {
        return view('auth.forgot-password');
    }

    function authConfirmEmail()
    {
        return view('auth.verify-email');
    }
    function getAjaxServiceList(Request $request){
        $items = \App\Models\Service::select('id', 'name as text')->where('status', 1)->where('type', 'fixed');

        $provider_id = !empty($request->provider_id) ? $request->provider_id : auth()->user()->id;
        $items->where('provider_id', $provider_id );
        if (isset($request->category_id)) {
            $items->where('category_id', $request->category_id);
        }
        if (isset($request->subcategory_id)) {
            $items->where('subcategory_id', $request->subcategory_id);
        }
        $items = $items->get();
        return response()->json(['status' => 'true', 'results' => $items]);
    }
}
