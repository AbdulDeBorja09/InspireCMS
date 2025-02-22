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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view("user.$viewName", $data);
    }

    public function ShowHome()
    {
        $articles = Articles::all();
        $services = Services::where('type', 'facility')->get();
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
        $facilities = Services::where('type', 'facility')->get();
        return $this->ShowPage('facilities', 'facilities', compact('facilities'));
    }

    public function ShowAcademies()
    {
        $academies = Services::where('type', 'academies')->get();
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
        return $this->ShowPage('profile', 'profile');
    }

    public function singleqoutation($id)
    {
        $facilities = Services::findOrFail($id);
        $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('singlepage', 'qoutepage', compact('facilities', 'rates'));
    }


    public function quotationpage()
    {
        $facilities = Services::where('type', 'facility')->get();
        $academies = Services::where('type', 'academies')->get();
        $membership = Services::where('type', 'membership')->get();
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
}
