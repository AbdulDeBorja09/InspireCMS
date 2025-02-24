<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\Section;
use App\Models\Contents;
use App\Models\FaqsCategory;
use App\Models\FaqsQuestions;
use App\Models\Partners;
use App\Models\Rate;
use App\Models\Services;
use App\Models\Teams;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Quotations;
use App\Models\notifications;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function ShowPage($sectionName, $viewName, $additionalData = [])
    {
        // Get the section and its contents
        $section = Section::where('name', $sectionName)->first();
        $contents = $section ? $section->contents->keyBy('key') : null;

        // Merge additional data into the view
        $data = array_merge(['contents' => $contents], $additionalData);

        // Display view with data
        return view("admin.$viewName", $data);
    }

    public function ShowDashboard()
    {
        $items = Quotations::whereIn('status', [1, 2, 3, 4])
            ->orderByRaw("CASE 
                    WHEN status = 1 THEN 0 
                    WHEN status = 2 THEN 1 
                    ELSE 2 
                END")
            ->get();

        $total =  Quotations::count();
        $pending =  Quotations::whereIn('status', [1, 2,])->count();
        $approved =  Quotations::whereIn('status', [3])->count();
        $completed =  Quotations::whereIn('status', [4])->count();
        return $this->ShowPage('dashboard', 'dashboard', compact('items', 'total', 'pending', 'approved', 'completed'));
    }

    public function ShowHome()
    {
        $articles = Articles::all();
        return $this->ShowPage('home', 'home', compact('articles'));
    }

    public function ShowArticles()
    {
        $articles = Articles::all();
        return $this->ShowPage('articles', 'articles', compact('articles'));
    }

    public function ShowFAQs()
    {
        $categories = FaqsCategory::all();
        $faqs = FaqsQuestions::all();
        return $this->ShowPage('faq', 'faq', compact('categories', 'faqs'));
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
        return $this->ShowPage('academies', 'academies', compact('academies'));
    }


    public function ShowMembership()
    {
        $membership = Services::where('type', 'membership')->get();
        return $this->ShowPage('membership', 'membership', compact('membership'));
    }

    public function ShowContactus()
    {
        $messages = ContactUs::all();
        return $this->ShowPage('contactus', 'contactus', compact('messages'));
    }

    public function ShowEditService($id)
    {
        $service = Services::findOrFail($id);
        $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('editpage', 'editpage', compact('service', 'rates'));
    }

    public function ShowSettings()
    {
        return $this->ShowPage('settings', 'settings');
    }

    public function ShowHeader()
    {
        $contents = Contents::pluck('value', 'key');
        return view('admin.header', compact('contents'));
    }

    public function ShowRequests()
    {
        $items = Quotations::whereIn('status', [0, 1, 2, 3])
            ->orderByRaw("CASE WHEN status = 1 THEN 0 WHEN status = 2 THEN 1  ELSE 2 END")
            ->get();

        return $this->ShowPage('requests', 'requests', compact('items'));
    }

    public function ShowPayments()
    {
        $items = Quotations::whereIn('status', [0, 1, 2, 3])
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
            ->get();

        return $this->ShowPage('requests', 'requests', compact('items'));
    }


    public function quotationpage()
    {
        $facilities = Services::where('type', 'facility')->get();
        $academies = Services::where('type', 'academies')->get();
        $membership = Services::where('type', 'membership')->get();
        return $this->ShowPage('quotation', 'quotation', compact('facilities', 'academies', 'membership'));
    }

    public function ChangePasswords(Request $request)
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

    public function CreateOrUpdateContent(Request $request)
    {
        // Remove CSRF token from request
        $data = $request->except('_token');

        // Create or get the section
        $section = Section::firstOrCreate(['name' => $request->section]);

        try {
            // Loop through the data (excluding the token) and store content
            foreach ($data as $key => $value) {
                if ($key !== 'section' && $value) {
                    // Handle image upload separately
                    if ($request->hasFile($key)) {
                        $file = $request->file($key);
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        // Move the file to the 'images' directory
                        $filePath = $file->storeAs('ContentImages', $fileName, 'public');

                        // Check if the record exists and delete the old file
                        $existingContent = Contents::where('section_id', $section->id)
                            ->where('key', $key)
                            ->first();

                        if ($existingContent && $existingContent->value) {
                            $oldFilePath = public_path('storage/' . $existingContent->value);
                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath); // Delete the old file
                            }
                        }

                        // Update the value to the new file path
                        $value = $filePath;
                    }

                    // Create or update the content in database
                    Contents::updateOrCreate(
                        ['section_id' => $section->id, 'key' => $key],
                        ['value' => is_array($value) ? json_encode($value) : $value, 'type' => gettype($value)]
                    );
                }
            }
            return redirect()->back()->with('success', 'Content saved successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function CreatePartners(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' =>  'mimes:jpeg,png,jpg,gif,svg,mp4,mkv,avi|max:10240',
        ]);
        try {
            $imagePath = null; // Default value if no image is uploaded

            // Check if the image is uploaded
            if ($request->hasFile('image')) {

                // Store the image in the 'storage/partners' directory
                $imagePath = $request->file('image')->store('partners', 'public');
            }
            // store in database
            Partners::create([
                'name' => $request->name,
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Partner saved successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function Createteam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' =>  'mimes:jpeg,png,jpg,gif,svg,mp4,mkv,avi|max:10240',
        ]);
        try {
            $imagePath = null; // Default value if no image is uploaded

            // Check if the image is uploaded
            if ($request->hasFile('image')) {

                // Store the image in the 'storage/teams' directory
                $imagePath = $request->file('image')->store('teams', 'public');
            }
            // store in database
            Teams::create([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Partner saved successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function CreateArticle(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'author' => 'required|string|max:255',
        //     'url1' => 'string|max:255',
        //     'url2' => 'string|max:255',
        //     'url3' => 'string|max:255',
        //     'url4' => 'string|max:255',
        //     'description' => 'string|max:255',
        //     'image' =>  'mimes:jpeg,png,jpg,gif,svg,mp4,mkv,avi|max:10240',
        // ]);
        try {
            $imagePath = null; // Default value if no image is uploaded

            // Check if the image is uploaded
            if ($request->hasFile('image')) {

                // Store the image in the 'storage/Articles' directory
                $imagePath = $request->file('image')->store('Articles', 'public');
            }

            // store in database
            $create = Articles::create([
                'title' => $request->title,
                'author'  => $request->author,
                'date'  => $request->date,
                'redirect_url'  => $request->redirect_url,
                'url1'  => $request->url1,
                'url2'  => $request->url2,
                'url3'  => $request->url3,
                'url4'  => $request->url4,
                'description'  => $request->description,
                'image' => $imagePath,
                'redirect' => $request->redirect,
            ]);
            if ($create) {
                return redirect()->back()->with('success', 'Partner saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function CreateFaqCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        try {
            // store in database
            $create = FaqsCategory::create([
                'name' => $request->name,
            ]);

            // Redirect back with message if success or not
            if ($create) {
                return redirect()->back()->with('success', 'Question saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function CreateFaqQuestions(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);
        try {
            // store in database
            $create = FaqsQuestions::create([
                'category_id' => $request->category_id,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            // Redirect back with message if success or not
            if ($create) {
                return redirect()->back()->with('success', 'Question saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save!');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function EditFaqs(Request $request)
    {
        $faqs = FaqsQuestions::findOrFail($request->id);
        try {


            $faqs->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'category_id' => $request->category_id,
            ]);
            return redirect()->back()->with('success', 'Question Edited successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function deletefaqs(Request $request)
    {
        // Find the data
        $faqs = FaqsQuestions::findOrFail($request->id);
        try {

            // Delete from database
            $faqs->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function editarticle(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'redirect_url' => 'nullable|string',
            'url1' => 'nullable|url',
            'url2' => 'nullable|string',
            'url3' => 'nullable|string',
            'url4' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);


        // Find the article by ID
        $article = Articles::findOrFail($request->id);

        try {
            $imagePath = $article->image; // Use existing image by default
            if ($request->hasFile('image')) {
                // Store the new image
                $imagePath = $request->file('image')->store('Articles', 'public');

                // Delete old image if it exists
                if ($article->image) {
                    $oldFilePath = public_path('storage/' . $article->image);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            // Update the article with new data
            $article->update([
                'title' => $request->title,
                'author' => $request->author,
                'date' => $request->date,
                'redirect_url' => $request->redirect_url,
                'url1' => $request->url1,
                'url2' => $request->url2,
                'url3' => $request->url3,
                'url4' => $request->url4,
                'description' => $request->description,
                'image' => $imagePath,
                'redirect' => $request->redirect,
            ]);

            // Log the success and redirect with a success message
            Log::info('Article updated successfully: ', $article->toArray());
            return redirect()->back()->with('success', 'Article updated successfully!');
        } catch (\Throwable $e) {
            // Log the error and return back with an error message
            Log::error('Failed to update article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update the article: ' . $e->getMessage());
        }
    }

    public function CreateService(Request $request)
    {

        try {
            $imagePaths = [];
            for ($i = 1; $i <= 4; $i++) {
                $imageKey = 'image' . $i;
                if ($request->hasFile($imageKey)) {
                    $imagePaths[$imageKey] = $request->file($imageKey)->store('facilities', 'public');
                } else {
                    $imagePaths[$imageKey] = null;
                }
            }
            $facility = Services::create([
                'type' => $request->type,
                'image1' => $imagePaths['image1'],
                'image2' => $imagePaths['image2'],
                'image3' => $imagePaths['image3'],
                'image4' => $imagePaths['image4'],
                'name' => $request->name,
                'brief' => $request->brief,
                'description' => $request->description,

            ]);
            foreach ($request->rate_type as $index => $rateType) {
                Rate::create([
                    'service_id' => $facility->id,
                    'rate_type' => $rateType,
                    'rate' => $request->rate[$index],
                    'unit' => $request->unit[$index] ?? null,
                    'inclusions' => $request->inclusions[$index] ?? null,
                    'hour' => $request->hour[$index] ?? null,
                ]);
            }
            return redirect()->back()->with('success', 'Question Edited successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function DelereArticle(Request $request)
    {
        // Find the data
        $article = Articles::findOrFail($request->id);
        try {

            // Delete from database
            $article->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function editpartner(Request $request)
    {
        // Find the article by ID
        $partner = Partners::findOrFail($request->id);

        try {
            $imagePath = $partner->image; // Use existing image by default
            if ($request->hasFile('image')) {
                // Store the new image
                $imagePath = $request->file('image')->store('partners', 'public');

                // Delete old image if it exists
                if ($partner->image) {
                    $oldFilePath = public_path('storage/' . $partner->image);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            // Update the article with new data
            $partner->update([
                'name' => $request->partnername,
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Article updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update the article: ' . $e->getMessage());
        }
    }

    public function deletepartner(Request $request)
    {
        // Find the data
        $partner = Partners::findOrFail($request->id);
        try {

            // Delete the image if it exists
            if ($partner->image) {
                $oldFilePath = public_path('storage/' . $partner->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Delete from database
            $partner->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function editeam(Request $request)
    {
        // Find the article by ID
        $team = Teams::findOrFail($request->id);

        try {
            $imagePath = $team->image; // Use existing image by default
            if ($request->hasFile('image')) {
                // Store the new image
                $imagePath = $request->file('image')->store('teams', 'public');

                // Delete old image if it exists
                if ($team->image) {
                    $oldFilePath = public_path('storage/' . $team->image);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            // Update the article with new data
            $team->update([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Article updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update the article: ' . $e->getMessage());
        }
    }

    public function deleteteam(Request $request)
    {
        // Find the data
        $team = Teams::findOrFail($request->id);
        try {

            // Delete the image if it exists
            if ($team->image) {
                $oldFilePath = public_path('storage/' . $team->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Delete from database
            $team->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function DeletRate(Request $request)
    {
        // Find the data
        $rate = Rate::findOrFail($request->id);
        try {

            // Delete from database
            $rate->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteService(Request $request)
    {
        // Find the data
        $service = Services::findOrFail($request->id);
        try {

            // Delete from database
            $service->delete();

            // Redirect back with message if success or not
            return redirect()->back()->with('success', 'Question Deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }


    public function NewRate(Request $request)
    {
        try {
            Rate::create([
                'service_id' => $request->id,
                'rate_type' => $request->rate_type,
                'rate' => $request->rate,
                'unit' => $request->unit,
                'inclusions' => $request->inclusions,
                'hour' => $request->hour,
            ]);
            return redirect()->back()->with('success', 'Rate Added successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function EditService(Request $request)
    {
        $service = Services::findOrFail($request->id);


        try {
            $imagePaths = [];
            for ($i = 1; $i <= 4; $i++) {
                $imageKey = 'image' . $i;

                if ($request->hasFile($imageKey)) {
                    // Delete the old image if it exists
                    if ($service->$imageKey) {
                        Storage::disk('public')->delete($service->$imageKey);
                    }
                    // Store the new image
                    $imagePaths[$imageKey] = $request->file($imageKey)->store('facilities', 'public');
                } else {
                    // Retain the old image if no new file is uploaded
                    $imagePaths[$imageKey] = $service->$imageKey;
                }
            }

            // Update the service record
            $service->update([
                'image1' => $imagePaths['image1'],
                'image2' => $imagePaths['image2'],
                'image3' => $imagePaths['image3'],
                'image4' => $imagePaths['image4'],
                'name' => $request->name,
                'brief' => $request->brief,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Rate Added successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }


    public function EditRate(Request $request)
    {
        $rate = Rate::findOrFail($request->id);
        try {
            $rate->update([
                'rate_type' => $request->rate_type,
                'rate' => $request->rate,
                'unit' => $request->unit,
                'inclusions' => $request->inclusions,
                'hour' => $request->hour,
            ]);
            return redirect()->back()->with('success', 'Rate Added successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function RejectRequest(Request $request)
    {
        $Quotations = Quotations::findOrFail($request->id);

        try {
            $Quotations->update([
                'status' => 0,
            ]);
            notifications::create([
                'user_id'  => $Quotations->user_id,
                'quotation_id' => $request->id,
                'message'  => $request->reason,
                'status'  => 'Rejected',
            ]);
            return redirect()->back()->with('success', 'Request Rejected successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }

    public function GetContactDetails(Request $request)
    {

        $Quotaions = Quotations::where('id', $request->id)->first();

        if ($Quotaions->status === 1) {
            $Quotaions->update([
                'status' => 2,
            ]);
        }
        return response()->json(json_decode($Quotaions->items, true));
    }

    public function ApproveRequest(Request $request)
    {
        $Quotations = Quotations::findOrFail($request->id);

        try {
            $Quotations->update([
                'status' => 3,
                'tax' => $request->tax,
                'discount' => $request->discount,
                'penalty' => $request->penalty,
                'Cancellation' => $request->cancelation,
            ]);

            notifications::create([
                'user_id'  => $Quotations->user_id,
                'quotation_id' => $request->id,
                'message'  => 'Your request for quotation has been approved.',
                'status'  => 'approved',
            ]);
            return redirect()->back()->with('success', 'Request Rejected successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()], 500);
        }
    }
}
