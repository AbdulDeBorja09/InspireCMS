<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\ContactUs;
use App\Models\Section;
use App\Models\Contents;
use App\Models\FaqsCategory;
use App\Models\Partners;
use App\Models\Rate;
use App\Models\Services;
use App\Models\Teams;
use App\Models\User;
use App\Models\Quotations;
use App\Models\notifications;
use App\Models\payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function ShowPage($sectionName, $viewName, $additionalData = [])
    {
        // Get the section and its contents
        $section = Section::where('name', $sectionName)->first();
        $contents = $section ? $section->contents->keyBy('key') : null;

        // Merge additional data into the view
        $data = array_merge(['contents' => $contents], $additionalData);

        // display view with data  
        return view("User.$viewName", $data);
    }

    public function ShowHome()
    {
        $articles = Articles::all();
        $services = Services::where('type', 'Facility')->get();
        return $this->ShowPage('home', 'home', compact('articles', 'services'));
    }

    public function ShowArticles()
    {
        $articles = Articles::all();
        return $this->ShowPage('articles', 'articles', compact('articles'));
    }

    public function ShowArticleContent($id)
    {
        $article = Articles::findOrFail($id);
        return $this->ShowPage('article content', 'singlearticle', compact('article'));
    }

    public function ShowFAQs()
    {
        $categories = FaqsCategory::all();
        return $this->ShowPage('faq', 'faq', compact('categories'));
    }

    public function ShowAbout()
    {
        $partners = Partners::all();
        $teams = Teams::all();
        return $this->ShowPage('about', 'about', compact('partners', 'teams'));
    }

    public function ShowFacilities()
    {
        $facilities = Services::where('type', 'Facility')->get();
        return $this->ShowPage('facilities', 'facilities', compact('facilities'));
    }

    public function ShowAcademies()
    {
        $academies = Services::where('type', 'Academy')->get();
        return $this->ShowPage('academy', 'academies', compact('academies'));
    }

    public function ShowRate($id)
    {
        $service = Services::findOrFail($id);
        $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('Content', 'singlecontent', compact('service', 'rates'));
    }

    public function ShowProfile()
    {
        $notif = notifications::with(['request'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $items = Quotations::where('user_id', Auth::user()->id)->get();
        return $this->ShowPage('profile', 'profile', compact('items', 'notif'));
    }


    public function ShowPayment(Request $request)
    {
        $quotations = Quotations::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
        if ($quotations) {
            $data = json_decode($quotations->items, true);
            return $this->ShowPage('payment', 'payment', compact('quotations', 'data'));
        } else {
            return redirect()->back()->with('error', 'Cant Found!');
        }
    }

    public function ShowConfirmation($id)
    {
        $quotation = Quotations::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $payment = payments::where('quotation_id', $id)->first();
        if ($quotation->status != 4) {
            return redirect()->route('user.home');
        } else {
            return view('user.confirmation', compact('payment', 'quotation'));
        }
    }

    public function singlequotation($id)
    {
        $service = Services::findOrFail($id);
        $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('Content', 'quotepage', compact('service', 'rates'));
    }

    public function QuotationPDF()
    {
        // $service = Services::findOrFail($id);
        // $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('Content', 'viewpdf');
    }

    public function quotationpage()
    {
        $facilities = Services::where('type', 'Facility')->get();
        $academies = Services::where('type', 'Academy')->get();
        $membership = Services::where('type', 'Membership')->get();
        return $this->ShowPage('quotation', 'quotation', compact('facilities', 'academies', 'membership'));
    }

    public function contactus(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        try {
            // store in database
            $create = ContactUs::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]);

            if ($create) {
                return redirect()->back()->with('success', 'Question saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function EditProfile(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        try {
            $imagePath = $user->image; // Use existing image by default
            if ($request->hasFile('image')) {
                // Store the new image
                $imagePath = $request->file('image')->store('Profiles', 'public');

                // Delete old image if it exists
                if ($user->image) {
                    $oldFilePath = public_path('storage/' . $user->image);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            $user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'image' => $imagePath,
            ]);

            if ($user) {
                return redirect()->back()->with('success', 'Profile Updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|max:255',
            'new_password' => 'required|string|max:255',
            'confirm_password' => 'required|string',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old Password Does Not Match!');
        } else {
            if ($request->new_password === $request->confirm_password) {
                try {
                    $user = User::where('id', Auth::user()->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                    if ($user) {
                        return redirect()->back()->with('success', 'Profile Updated successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Failed to save!');
                    }
                } catch (\Throwable $e) {
                    return redirect()->back()->with(['error' => $e->getMessage()], 500);
                }
            } else {
                return redirect()->back()->with('error', 'Password Not Match!');
            }
        }
    }

    public function CreateQuotation(Request $request)
    {

        $service = Services::with('rates')->where('id', $request->service_id)->first();
        $rates = Rate::where('id', $request->rate_type)->first();

        // Initialize total price and total hours
        $totalPrice = 0;
        $IndvRate = 0;
        $totalHours = null;

        // If the service has rates and you are looking for 'individual' rate
        if ($service && $service->rates->isNotEmpty()) {
            // Find the rate that matches 'individual' rate_type
            $rate = $service->rates->firstWhere(function ($rate) {
                return Str::contains(strtolower($rate->rate_type), 'individual');
            });

            if ($rate) {
                // If there is a rate and guests are provided, calculate total price
                if ($request->guests) {
                    $totalPrice = $rate->rate * $request->guests;
                    $IndvRate = $rate->rate;
                }
            }
        }

        // If start and end dates are provided, calculate total hours
        if ($request->start_time && $request->end_time) {
            $startTime = Carbon::parse($request->start_time);
            $endTime = Carbon::parse($request->end_time);

            // Ensure the start time is always earlier than the end time
            if ($endTime->lt($startTime)) {
                // Swap start and end times if necessary
                $temp = $startTime;
                $startTime = $endTime;
                $endTime = $temp;
            }

            // Calculate the difference in hours
            $totalHours = ceil($startTime->diffInHours($endTime));
        }

        // Prepare quotation data
        $quotationData = [
            'service_id' => $request->service_id,
            'service_type' => $request->service_type,
            'service_name' => $request->service_name,
            'rate_type' => $rates->rate_type,
            'rate' => $rates->rate ?? 0,
            'hours' => $totalHours,
            'qty' => $request->qty,
            'guest' => $request->guests,
            'total_price' => $totalPrice,
            'individual' => $totalPrice,
            'individual_base' => $IndvRate,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,

        ];

        // Store the quotation data in session
        Session::put('quotation_data', $quotationData);

        // Pass data to the view
        return $this->ShowPage('Payment', 'viewpdf', compact('quotationData'));
    }

    public function SubmitQuotationRequest(Request $request)
    {
        $quotationRef = 'QUO-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        $quotationDataJson = json_encode([
            'service_name' => $request->service_name,
            'rate_name' => $request->rate_type,
            'rate_value' => $request->rate,
            'total_hours' => $request->hours ?? 0,
            'guest_qty' => $request->qty ?? 0,
            'total_price' => $request->total_price ?? 0,
            'individual_rate' => $request->individual_base ?? 0,
            'individual_total' => $request->individual ?? 0,
            'guest_count' => $request->guest ?? 0,
            'subtotal' => $request->subtotal ?? 0,
        ]);

        try {
            Quotations::create([
                'user_id' => Auth::user()->id,
                'Quotation_ref' => $quotationRef,
                'service_id' => $request->service_id,
                'service_type' => $request->service_type ?? 'test',
                'items' => $quotationDataJson,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total' => $request->subtotal,
            ]);

            return redirect()->route('quotationpage');
        } catch (\Throwable $e) {
            return redirect()->route('quotationpage');
        }
    }


    public function SubmitPayment(Request $request)
    {
        $quotation = Quotations::findOrFail($request->id);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('Proofs', 'public');
            }

            $payment = Payments::create([
                'quotation_id' => $request->id,
                'payment_term' => $request->payment_term,
                'name'  => $request->fname . ' ' . $request->lname,
                'address'  => $request->address,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'proof'  => $imagePath,
            ]);


            if ($payment) {
                $quotationRef = 'PAY-' . now()->format('Ymd') . '-' . now()->format('h') . Str::upper(Str::random(4));
                $quotation->update([
                    'Quotation_ref' => $quotationRef,
                    'event_title' => $request->title,
                    'billing_name' => $request->fname . ' ' . $request->lname,
                    'billing_address' => $request->address,
                    'status' => 4,
                ]);
                notifications::where('quotation_id', $request->id)->delete();
                return redirect()->route('ShowConfirmation', ['id' => $quotation->id])->with('success', 'Payment saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }
}
