<?php

namespace App\Http\Controllers;

use App\Models\ExpertiseArea;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpertiseAreaController extends Controller
{
    public function index()
    {
        return view('admin.expertise.index');
    }

    public function getIconUrl($request)
    {
        $slug = Str::slug($request->name);
        $icon = $request->file('icon');
        $iconName = $slug.'-'.time().'.'.$icon->getClientOriginalExtension();
        $directory = 'expertise-icon/';
        $icon->move($directory,$iconName);
        $iconUrl = $directory.$iconName;
        return $iconUrl;
    }

    public function create(Request $request)
    {
        $expertise = new ExpertiseArea();
        $expertise->name = $request->name;
        if ($request->file('icon'))
        {
            $expertise->icon = $this->getIconUrl($request);
        }
        if ($request->status)
        {
            $expertise->status = $request->status;
        }
        else {
            $expertise->status = 2;
        }
        $expertise->save();
        flash()->success('Expertise Area', 'Expertise area add successfully');
        return redirect()->back();
    }

    public function edit($id)
    {
        $expertise = ExpertiseArea::find($id);

        return response()->json([
            'status' => 200,
            'expertise' => $expertise
        ]);
    }

    public function update(Request $request)
    {
        $expertise = ExpertiseArea::find($request->expertise_id);
        $expertise->name = $request->name;
        if ($request->file('icon'))
        {
            if (file_exists($expertise->icon))
            {
                unlink($expertise->icon);
            }
            $iconUrl = $this->getIconUrl($request);
        }
        else {
            $iconUrl = $expertise->icon;
        }
        $expertise->icon = $iconUrl;
        if ($request->status)
        {
            $expertise->status = $request->status;
        }
        else {
            $expertise->status = 2;
        }
        $expertise->save();
        flash()->success('Expertise Area', 'Expertise area update successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        $expertise = ExpertiseArea::find($id);
        if (file_exists($expertise->icon))
        {
            unlink($expertise->icon);
        }
        $expertise->delete();

        flash()->success('Expertise Area', 'Expertise area delete successfully');
        return redirect()->back();
    }
}
