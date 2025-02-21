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
use Illuminate\Support\Facades\Log;

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
        $facilities = Services::where('type', 'facility')->get();
        return $this->ShowPage('facilities', 'facilities', compact('facilities'));
    }

    public function ShowAcademies()
    {
        $academies = Services::where('type', 'academies')->get();
        return $this->ShowPage('academies', 'academies', compact('academies'));
    }

    public function ShowRate($id)
    {
        $service = Services::findOrFail($id);
        $rates = Rate::where('service_id', $id)->get();
        return $this->ShowPage('singlepage', 'singlecontent', compact('service', 'rates'));
    }

    public function quotationpage()
    {
        $facilities = Services::where('type', 'facility')->get();
        $academies = Services::where('type', 'academies')->get();
        $membership = Services::where('type', 'membership')->get();
        return $this->ShowPage('quotation', 'quotation', compact('facilities', 'academies', 'membership'));
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

        // Log the request data
        Log::info($request->all());

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
                'description' => $request->description,

            ]);
            foreach ($request->rate_type as $index => $rateType) {
                Rate::create([
                    'service_id' => $facility->id,
                    'rate_type' => $rateType,
                    'rate' => $request->rate[$index],
                    'unit' => $request->unit[$index] ?? null,
                    'inclusions' => $request->inclusions[$index] ?? null,
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
}
