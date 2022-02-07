<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAboutRequest;
use App\Http\Requests\SaveContactRequest;
use App\Http\Requests\SaveHeroRequest;
use App\Http\Resources\SettingsResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    private $settings;

    function __construct()
    {
        $this->settings = Setting::find(1) ?? new Setting();
    }

    public function create(Request $request)
    {
        return Inertia::render('Settings/Create', [
            'settings' => new SettingsResource($this->settings)
        ]);
    }

    public function saveHero(SaveHeroRequest $request)
    {
        $data['hero_description'] = $request->get('hero_description');

        if ($request->file('hero_image')) {

            $this->settings->deleteImage('data->hero_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('hero_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->execute();

            $data['hero_image'] = $imageName;
        }


        $this->save($data);

        return redirect()->back();
    }

    public function saveAbout(SaveAboutRequest $request)
    {
        $data['about_description'] = $request->get('about_description');

        if ($request->file('about_image')) {

            $this->settings->deleteImage('data->about_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('about_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->execute();

            $data['about_image'] = $imageName;
        }


        $this->save($data);

        return redirect()->back();
    }

    public function saveContact(SaveContactRequest $request)
    {

        $data = $request->only(['address', 'email', 'phone', 'google_map_url']);

        if ($request->file('contact_image')) {

            $this->settings->deleteImage('data->contact_image');

            $imageName = (new UploadFile)
                ->setFile($request->file('contact_image'))
                ->setUploadPath($this->settings->uploadFolder())
                ->execute();

            $data['contact_image'] = $imageName;
        }


        $this->save($data);

        return redirect()->back();
    }

    private function save(array $data)
    {
        // dd($this->settings->data);
        $this->settings->data = $this->settings->data
            ? array_merge($this->settings->data, $data)
            : $data;
        $this->settings->save();
    }
}
