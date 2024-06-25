<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkExperienceController extends Controller
{
    public function index()
    {
        return view('admin.experience.index');
    }

    public function getIconUrl($request)
    {
        $slug = Str::slug($request->name);
        $icon = $request->file('icon');
        $iconName = $slug.'-'.time().'.'.$icon->getClientOriginalExtension();
        $directory = 'work-experience/';
        $icon->move($directory,$iconName);
        $iconUrl = $directory.$iconName;
        return $iconUrl;
    }

    public function create(Request $request)
    {
        $experience = new WorkExperience();
        $experience->name = $request->name;
        $experience->position = $request->position;
        $experience->working_year = $request->working_year;
        $experience->icon = $this->getIconUrl($request);
        if ($request->status)
        {
            $experience->status = $request->status;
        }
        else
        {
            $experience->status = 2;
        }
        $experience->save();

        flash()->success('Work experience', 'Work Experience add successfully');
        return redirect()->back();
    }

    public function manage()
    {
        $experiences = WorkExperience::latest()->get();
        return view('admin.experience.manage', compact('experiences'));
    }

    public function edit($id)
    {
        $experience = WorkExperience::find($id);
        return view('admin.experience.edit', compact('experience'));
    }

    public function update(Request $request, $id)
    {
        $experience = WorkExperience::find($id);
        $experience->name = $request->name;
        $experience->position = $request->position;
        $experience->working_year = $request->working_year;
        if ($request->file('icon'))
        {
            if (file_exists($experience->icon))
            {
                unlink($experience->icon);
            }
            $iconUrl = $this->getIconUrl($request);
        }
        else
        {
            $iconUrl = $experience->icon;
        }
        $experience->icon = $iconUrl;
        if ($request->status)
        {
            $experience->status = $request->status;
        }
        else
        {
            $experience->status = 2;
        }
        $experience->save();

        flash()->success('Work experience', 'Work Experience update successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        $experience = WorkExperience::find($id);
        if (file_exists($experience->icon))
        {
            unlink($experience->icon);
        }
        $experience->delete();

        flash()->success('Work Experience', 'Work experience delete successfully');
        return redirect()->back();
    }
}
